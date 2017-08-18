<?php

namespace Modules\Anuncio\Http\Controllers\Api\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Anuncio\Criteria\AnuncioCriteria;
use Modules\Anuncio\Criteria\AnuncioFrontCriteria;
use Modules\Anuncio\Criteria\AnuncioScoreOrderCriteria;
use Modules\Anuncio\Criteria\AnuncioStatusCriteria;
use Modules\Anuncio\Models\Anuncio;
use Modules\Anuncio\Models\Score;
use Modules\Anuncio\Repositories\AnuncioExcluirFormRepository;
use Modules\Anuncio\Repositories\AnuncioFrontRepository;
use Modules\Core\Services\ImageUploadService;
use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Anuncio\Http\Requests\AnuncioRequest;
use Modules\Anuncio\Services\AnuncioService;
use Portal\Models\Imagem;
use Portal\Repositories\ImagemRepository;
use Portal\Services\CacheService;
use Prettus\Repository\Exceptions\RepositoryException;

class AnuncioController extends BaseController
{
    const TIME_CACHE = 10;

    /**
     * @var AnuncioFrontRepository
     */
    private $anuncioRepository;

    /**
     * @var AnuncioService
     */
    private $anuncioService;
    /**
     * @var CacheService
     */
    private $cacheService;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;
    /**
     * @var ImagemRepository
     */
    private $imagemRepository;
    /**
     * @var AnuncioExcluirFormRepository
     */
    private $anuncioExcluirFormRepository;

    public function __construct(
        AnuncioFrontRepository $anuncioRepository,
        AnuncioService $anuncioService,
        CacheService $cacheService,
        ImageUploadService $imageUploadService,
        ImagemRepository $imagemRepository,
        AnuncioExcluirFormRepository $anuncioExcluirFormRepository)
    {
        parent::__construct($anuncioRepository, AnuncioCriteria::class);
        $this->setPathFile(public_path('arquivos/img/anuncio'));
        $this->anuncioRepository = $anuncioRepository;
        $this->anuncioService = $anuncioService;
        $this->cacheService = $cacheService;
        $this->imageUploadService = $imageUploadService;
        $this->imagemRepository = $imagemRepository;
        $this->anuncioExcluirFormRepository = $anuncioExcluirFormRepository;
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new AnuncioRequest())->rules($id);
        return $this->validator;
    }

    /**
     * Consultar
     *
     *
     * Endpoint para consultar todos os Anuncio cadastrados
     *
     * Nessa consulta pode ser aplicado os seguintes filtros:
     *
     *  - Consultar Normal:
     *   <br> - Não passar parametros
     *
     *  - Consultar por Cidade:
     *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
     */
    public function index(Request $request)
    {
        try {
            $userId = $this->getUserId();
            return $this->anuncioRepository
                ->pushCriteria(new AnuncioFrontCriteria($request, $userId))
                ->pushCriteria(new OrderCriteria($request))
                ->paginate(self::$_PAGINATION_COUNT);
            /*$userId = $this->getUserId();
            $cacheId = 'user_' . $userId . $request->get('page');
            if (!$this->cacheService->has($cacheId)) {
                $this->cacheService->put($cacheId, $this->anuncioRepository
                    ->pushCriteria(new AnuncioFrontCriteria($request, $userId))
                    ->pushCriteria(new OrderCriteria($request))
                    ->paginate(self::$_PAGINATION_COUNT), 2);
            }
            return $this->cacheService->get($cacheId);*/
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function store(Request $request)
    {
        $request->merge(['user_id' => $this->getUserId()]);
        $data = $request->all();
        \Validator::make($data, $this->getValidator())->validate();
        try {
            return $this->anuncioRepository->createByEnderecoPreco($data);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        \Validator::make($data, $this->getValidator($id))->validate();
        try {
            $anuncio = $this->anuncioService->findByUser($id, $this->getUserId());
            if ($anuncio['data']['user_id'] != $this->getUserId()) {
                throw new \Exception('Anuncio inexistente!');
            }
            return $this->anuncioRepository->updateByEnderecoPreco($data, $anuncio['data']['id']);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function removerByPesquisa(Request $request, $slug){
        $data = $request->all();
        if($data){
            $data = $request->only([
                'satisfacao',
                'satisfacao_text',
                'vendeu_qimob',
                'vendeu_qimob_valor',
                'vendeu_qimob_outro',
                'depoimento',
                'depoimento_text',
            ]);
            \Validator::make($data, [
                'satisfacao' => 'required|boolean',
                'satisfacao_text' => 'max:500',
                //required_if:satisfacao,true|
                'vendeu_qimob' => 'required|in:sim,nao_outra_forma,nao_vendi',
            ])->validate();
        }
        \DB::beginTransaction();
        try{
            $this->anuncioService->desativarAnuncioAnunciante($slug, $this->getUserId(), $data);
            \DB::commit();
            return self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_EXCLUIDO);
        }catch (ModelNotFoundException $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }catch (RepositoryException $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }catch (\Exception $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function ofertasCapa(Request $request)
    {
        try {
            return $this->anuncioService->ofertasCapa($request);
        } catch (\Exception $e) {
            $request->merge(['cep' => '77202556']);
            return $this->anuncioService->ofertasCapa($request);
        }

    }

    public function show($id)
    {
        try {
            $anuncio = $this->anuncioService->findByUser($id, $this->getUserId());
            if (is_null($anuncio))
                throw new \Exception('Anúncio não pode ser retornado!');
            return $anuncio;
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function scoreTelefone($id)
    {
        try{
            $this->anuncioService->bloqueioDeScore(Score::LABEL_FONE_CLICK, $this->getUserId(), $id, self::TIME_CACHE);
            return self::responseSuccess(self::HTTP_CODE_OK, "view registrada");
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function scoreImpressao($id)
    {
        $this->anuncioService->bloqueioDeScore(Score::LABEL_IMPRIMIR, $this->getUserId(), $id, self::TIME_CACHE);
    }

    public function scorePermanencia($id)
    {
        $this->anuncioService->bloqueioDeScore(Score::LABEL_PERMANENCIA, $this->getUserId(), $id, self::TIME_CACHE);
    }

    public function scoreFavoritar($id)
    {
        $this->anuncioService->bloqueioDeScore(Score::LABEL_FAVORITO, $this->getUserId(), $id, self::TIME_CACHE);
    }

    public function scoreAlerta($id)
    {
        $this->anuncioService->bloqueioDeScore(Score::LABEL_ALERT, $this->getUserId(), $id, self::TIME_CACHE);
    }

    public function scoreCompartilhar($id)
    {
        $this->anuncioService->bloqueioDeScore(Score::LABEL_COMPARTILHAR, $this->getUserId(), $id, self::TIME_CACHE);
    }

    /**
     * Consulta  por ID
     *
     * Endpoint para consultar passando o ID como parametro
     *
     * @param $id
     * @return retorna um registro
     */
    public function vizualizar($slug)
    {
        try {
            $anuncio = $this->anuncioService->findByAtivo($slug);
            $this->anuncioService->bloqueioDeScore(Score::LABEL_VIEW, $this->getUserId(), $anuncio['data']['id'], self::TIME_CACHE);
            return $anuncio;
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    /**
     * Consultar pelo front
     *
     *
     * Endpoint para consultar todos os Anuncio cadastrados
     *
     * Nessa consulta pode ser aplicado os seguintes filtros:
     *
     *  - Consultar Normal:
     *   <br> - Não passar parametros
     *
     *  - Consultar por Cidade:
     *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
     */
    public function listSite(Request $request)
    {
        try {
            $cacheId = '1' . $request->get('page');
            $data = $request->all();
            if (!is_null($data))
                $cacheId = base64_encode(json_encode($data).$cacheId);
            //$this->cacheService->forget($cacheId);
            if (!$this->cacheService->has($cacheId)) {
                $this->cacheService->put($cacheId,
                    $this->anuncioRepository
                        ->pushCriteria(new AnuncioCriteria($request))
                        ->pushCriteria(new AnuncioStatusCriteria())
                        ->pushCriteria(new AnuncioScoreOrderCriteria())
                        ->pushCriteria(new OrderCriteria($request))
                        ->paginate(self::$_PAGINATION_COUNT));
            }
            return $this->cacheService->get($cacheId);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function salvarImagem(Request $request, $id)
    {
        $request->merge(['max_imagens' => $id]);
        $request->merge(['anuncio' => $id]);
        $data = $request->all();
        \Validator::make($data, [
            'imagem' => 'array|max:10',
            'max_imagens' => "count:10," . Anuncio::class,
            'anuncio' => '|exists:anuncios,id',
            'imagem.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,bmp,png'
            ]
        ])->validate();

        $anuncio = $this->anuncioRepository->skipPresenter(true)->find($id);
        if ($anuncio->user_id != $this->getUserId()) {
            throw new \Exception('Anuncios não encontrado!' . $this->getUserId());
        }
        $result = [];
        foreach ($data['imagem'] as $key => $img) {
            $aux = ['imagem' => $img];
            $this->imageUploadService->upload('imagem', $this->getPathFile(), $aux);
            $filemake = explode('.', $aux['imagem']);
            $imagem_list = Imagem::$tamanhos;
            foreach ($imagem_list['anuncio'] as $index => $item) {
                $this->imageUploadService->cropPhoto('arquivos/img/anuncio/' . $aux['imagem'], array(
                    'width' => $item['w'],
                    'height' => $item['h'],
                    'grayscale' => false
                ), 'arquivos/img/anuncio/' . $filemake[0] . '_' . $index . '.' . $filemake[1]);
            }
            $imagem = $this->imagemRepository->create([
                'img' => $aux['imagem'],
                'imagemtable_id' => $id,
                'imagemtable_type' => Anuncio::class,
                'princial' => false,
                'prioridade' => $key + 1
            ]);
            $result['data'][$key] = $imagem['data'];
            $result['data'][$key]['img'] = \URL::to('/') . '/arquivos/img/anuncio/' . $filemake[0] . '_img_230_160.' . $filemake[1];
        }
        return $result;

    }

    public function imagensByAnuncios($id)
    {
        try {
            return $this->anuncioRepository->skipPresenter(true)->find($id)->imagens;
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Deletar
     *
     * Endpoint para deletar passando o ID
     */
    public function destroyImage($id)
    {
        try {
            $this->imagemRepository->delete($id);
            return self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_EXCLUIDO);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function reOrdenar(Request $request)
    {
        $data = $request->all();
        \Validator::make($data, [
            'imagem' => 'array|max:10',
            'imagem.*' => [
                'required'
            ]
        ])->validate();
        try {
            foreach ($data['imagem'] as $key => $img) {
                $imagem = $this->imagemRepository->skipPresenter(true)->find($img['id']);
                $imagem->principal = $img['principal'];
                $imagem->prioridade = $key + 1;
                $imagem->save();
            }
            return parent::responseSuccess(parent::HTTP_CODE_OK, 'imagens alterada com sucesso');
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

}
