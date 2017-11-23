<?php


namespace Modules\Anuncio\Services;


use Illuminate\Http\Request;
use Modules\Anuncio\Events\GerarScore;
use Modules\Anuncio\Models\Anuncio;
use Modules\Anuncio\Models\Score;
use Modules\Anuncio\Repositories\AnuncioExcluirFormRepository;
use Modules\Core\Models\Role;
use Modules\Localidade\Repositories\EnderecoRepository;
use Modules\Anuncio\Repositories\AnuncioFrontRepository;
use Modules\Localidade\Services\CepService;
use Modules\Plano\Models\PlanoContratacao;
use Portal\Services\CacheService;

class AnuncioService
{
    /**
     * @var AnuncioFrontRepository
     */
    private $anuncioRepository;
    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;
    /**
     * @var CacheService
     */
    private $cacheService;

    private static $unset_protect = [
        'anunciante' => [
            'name',
            'imagem',
            'cpf_cnpj',
            'email',
            'endereco'
        ]
    ];
    /**
     * @var CepService
     */
    private $cepService;
    /**
     * @var AnuncioExcluirFormRepository
     */
    private $anuncioExcluirFormRepository;

    public function __construct(
        AnuncioFrontRepository $anuncioRepository,
        EnderecoRepository $enderecoRepository,
        CacheService $cacheService,
        AnuncioExcluirFormRepository $anuncioExcluirFormRepository,
        CepService $cepService)
    {
        $this->anuncioRepository = $anuncioRepository;
        $this->enderecoRepository = $enderecoRepository;
        $this->cacheService = $cacheService;
        $this->cepService = $cepService;
        $this->anuncioExcluirFormRepository = $anuncioExcluirFormRepository;
    }

    public function create($data)
    {
        \DB::beginTransaction();
        try {
            $anuncio = $this->anuncioRepository->create($data);
            $anuncio->endereco()->save($data['endereco'])
                ->precos()->save([
                    'valor' => $data['valor'],
                    'valor_condominio' => floatval($data['valor_condominio']),
                ]);
            \DB::commit();
            return $anuncio;
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    public function bloqueioDeScore($tipo, $userId, $anuncioId, $time = 1)
    {
        if (!$this->cacheService->has('user_' . $userId . '_anuncio_' . $anuncioId)) {
            $this->cacheService->put('user_' . $userId . '_anuncio_' . $anuncioId, 'start_time', $time);
            event(new GerarScore($tipo, Score::_getValue($tipo), $anuncioId, $userId));
        }
    }

    public function findByUser($id, $userId)
    {
        return $this->anuncioRepository->findByUser($id, $userId);
    }

    public function findByAtivo($slug, $time = 5)
    {
        if (!$this->cacheService->has($slug)) {
            $anuncio = $this->anuncioRepository->findByAtivo($slug);
            if (is_null($anuncio)) {
                return null;
            }
            $this->cacheService->put($slug, $anuncio, $time);
            return $this->protectkeys(self::$unset_protect, $anuncio);
        }
        return $this->protectkeys(self::$unset_protect, $this->cacheService->get($slug));
    }

    public function ofertasCapa(Request $request)
    {
        //TODO criar método de ofertas da capa.
        $cep = $request->get('cep');
        if (!is_null($cep)) {
            $localizacao = [];
            $cep = $this->cepService->requestCep($cep, true);
            $localizacao['city'] = $cep['data']['cidade_titulo'];
            $localizacao['region'] = $cep['data']['estado_uf'];
        } else {
            $localizacao = $this->cepService->requestIp();
        }
        //$this->cepService->requestCepByGeoLocation(-10.1848934,-48.3268008);
        $cidadeEstado = $localizacao['city'] . ' - ' . $localizacao['region'];
        $cacheId = base64_encode($cidadeEstado);
        //$this->cacheService->forget($cacheId);
        if ($this->cacheService->has($cacheId)) {
            return $this->cacheService->get($cacheId);
        }
        $options = ['vitrineImoveisComprar' => [], 'vitrineImoveisAlugar' => [], 'ultimosAnuncios' => [], 'mostrarVitrine' => true, 'localidade' => null];
        $query = [];
        if ($localizacao) {
            $query = [
                ['cidades.titulo', 'ilike', $localizacao['city']],
                ['estados.uf', 'ilike', $localizacao['region']]
            ];
        }
        $options['vitrineImoveisAlugar'] = $this->anuncioRepository->limitByPretensao(Anuncio::TYPE_ALUGAR, $query, 8);
        $options['vitrineImoveisComprar'] = $this->anuncioRepository->limitByPretensao(Anuncio::TYPE_VENDER, $query, 6);
        $options['vitrineEmpreendimentos'] = $this->anuncioRepository->limitByPretensao(Anuncio::TYPE_LANCAMENTO, $query, 6);
        $options['ultimosAnuncios'] = $this->anuncioRepository->ultimosBylimit($query, 8);
        $options['localidade'] = $cidadeEstado;
        $this->cacheService->put($cacheId, $options, 30);
        return $options;

    }

    private function protectkeys($protect, array $item)
    {
        foreach ($protect as $key => $value) {
            if (is_array($value)) {
                $item['data'][$key]['data'] = array_intersect_key($item['data'][$key]['data'], array_flip($value));
            } else {
                unset($item['data'][$key]);
            }
        }
        return $item;
    }


    public function desativarAnuncioAnunciante($slug, int $userId, array $pesquisa = null)
    {
        $anuncio = $this->anuncioRepository->skipPresenter(true)->findWhere([
            'slug' => $slug,
            'user_id' => $userId,
            //'status' => Anuncio::STATUS_ATIVO
        ]);
        if ($anuncio->count() == 0) {
            throw new \Exception('Anuncio inesistente!');
        }

        $anuncio = $anuncio->first();
        if ($anuncio->user_id != $userId) {
            throw new \Exception('Anuncio não pertence a você!');
        }

        if ($anuncio->houvecontratacao->count() > 0) {
            if ($pesquisa) {
                $pesquisa['anuncio_id'] = $anuncio->id;
                $this->anuncioExcluirFormRepository->create($pesquisa);
            }

            $anuncio->status = Anuncio::STATUS_INATIVO;
            $anuncio->save();
            if ($anuncio->contratacaoAtiva->count() > 0) {
                $contratacao = $anuncio->contratacaoAtiva->first();
                $contratacao->data_fim = \Carbon\Carbon::now();
                $contratacao->status = PlanoContratacao::STATUS_FINALIZADO;
                $contratacao->save();
            }
        }else{
            $anuncio->status = Anuncio::STATUS_INATIVO;
            $anuncio->remove_site_view = \Carbon\Carbon::now();
            $anuncio->save();
        }

    }

    public function logPesquisa(){

	}

}