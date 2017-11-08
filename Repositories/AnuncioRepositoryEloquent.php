<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Models\AnuncioCondicaoComercial;
use Modules\Anuncio\Models\AnuncioPreco;
use Modules\Anuncio\Presenters\AnuncioPresenter;
use Modules\Localidade\Models\Endereco;
use Modules\Localidade\Models\Telefone;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioRepository;
use Modules\Anuncio\Models\Anuncio;
use Modules\Anuncio\Validators\AnuncioValidator;

/**
 * Class AnuncioRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioRepositoryEloquent extends BaseRepository implements AnuncioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Anuncio::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return AnuncioPresenter::class;
    }

    public function createByEnderecoPreco(array $data)
    {
        \DB::beginTransaction();
        try {
            $anuncio = $this->model->create($data);
            $anuncio->endereco()->save(Endereco::create($data['endereco']));
            $this->salvarPreco($anuncio, $anuncio->id, $data);
            if (isset($data['anuncio_condicao_comercial'])) {
                $this->createCondicao($anuncio, $data);
            }

            if (isset($data['caracteristicas'])) {
                $anuncio->caracteristicas()->attach($data['caracteristicas']);
            }

            if (isset($data['telefones'])) {
                foreach ($data['telefones']['ddd'] as $key => $ddd) {
                    $anuncio->telefones()->create([
                        'ddd' => $ddd,
                        'numero' => $data['telefones']['numero'][$key],
                        'principal' => $data['telefones']['principal'][$key],
                        'tipo' => $data['telefones']['tipo'][$key],
                    ]);
                }
            }
            $result = $this->parserResult($this->generateSlug($this->model->find($anuncio->id)));
            \DB::commit();
            return $result;
        } catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }
    }

    private function generateSlug($item)
    {
        if ($item->tipo == Anuncio::TYPE_ANUNCIO_IMOVEL) {
            $item->slug = str_slug($item->tipo . ' ' .
                (($item->finalidade) ? $item->finalidade->titulo : '') . ' ' .
                $item->pretensao . ' ' .
                (($item->qtde_dormitorio == 0)?'':$item->qtde_dormitorio)  . ' quartos ' .
                $item->area_util . ' m2 n' .
                $item->id . ' ' .
                (($item->endereco) ? $item->endereco->endereco : '') . ' ' .
                (($item->endereco) ? $item->endereco->bairro->titulo : '') . ' ' .
                (($item->endereco) ? $item->endereco->cidade->titulo : '') . ' ' .
                (($item->endereco) ? $item->endereco->estado->uf : ''), '+');
        } else {
            $item->slug = str_slug(
                $item->tipo . ' ' .
                $item->pretensao . ' ' .
                (($item->endereco) ? $item->endereco->estado->uf : '') . ' ' .
                (($item->endereco) ? $item->endereco->cidade->titulo : '') . ' ' .
                (($item->endereco) ? $item->endereco->bairro->titulo : '') . ' ' .
                (($item->endereco) ? $item->endereco->endereco : '') . ' ' .
                $item->titulo .
                (($item->qtde_area_minimo) ? $item->qtde_area_minimo . ' m2 ' : '') .
                (($item->qtde_area_maximo) ? $item->qtde_area_maximo . ' m2 ' : '' .
                    'n' . $item->id), '+');
        }
        $item->save();
        return $item;

    }

    public function ultimosBylimit(array $query, $limit)
    {
        $anuncios = $this->scopeQuery(function ($scope) use ($query, $limit) {
            $scope = $scope
                ->limit($limit)
                ->orderBy('created_at', 'desc')
                ->where('remove_site_view', '=', null)
                ->leftJoin('enderecos', function ($join) {
                    $join->on('anuncios.id', '=', 'enderecos.enderecotable_id');
                    $join->where('enderecos.enderecotable_type', '=', Anuncio::class);
                })
                ->leftJoin('cidades', 'enderecos.cidade_id', 'cidades.id')
                ->leftJoin('estados', 'enderecos.estado_id', 'estados.id')
                ->where('status', '=', true)
                ->select(['anuncios.*']);
            $this->queryBuilder($scope, $query);
            return $scope;
        })->all();
        return (empty($anuncios['data']) ? null : $anuncios);
    }

    public function limitByPretensao($pretensao, array $query, $limit)
    {
        $anuncios = $this->scopeQuery(function ($scope) use ($pretensao, $query, $limit) {
            $scope = $scope
                ->where('anuncios.pretensao', '=', $pretensao)
                ->where('anuncios.status', '=', true)
                ->orderBy('score', 'desc')
                ->leftJoin('enderecos', function ($join) {
                    $join->on('anuncios.id', '=', 'enderecos.enderecotable_id');
                    $join->where('enderecos.enderecotable_type', '=', Anuncio::class);
                })
                ->leftJoin('cidades', 'enderecos.cidade_id', 'cidades.id')
                ->leftJoin('estados', 'enderecos.estado_id', 'estados.id')
                ->limit($limit)
                ->select(['anuncios.*']);
            $this->queryBuilder($scope, $query);
            return $scope;
        })->all();
        return (empty($anuncios['data']) ? null : $anuncios);
    }

    private function queryBuilder(&$model, array $query)
    {
        foreach ($query as $q) {

            if (count($q) != 3)
                throw new \Exception('Erro ao montar os parametos por favor passe Ex ["field", "comparer", "value" ]');

            list($field, $comparer, $value) = $q;
            $model = $model->where($field, $comparer, $value);
        }
    }

    public function updateByEnderecoPreco(array $data, $id)
    {
        \DB::beginTransaction();
        try {
            unset($data['endereco']['cidade_name']);
            unset($data['endereco']['estado_name']);
            unset($data['endereco']['cidade']);
            unset($data['endereco']['estado']);
            unset($data['endereco']['bairro']);
            unset($data['endereco']['estado_uf']);
            $anuncio = $this->model->findOrFail($id);
            $anuncio->fill($data);
            if ($anuncio->isDirty('valor') || $anuncio->isDirty('valor_condominio')) {
                $this->salvarPreco($anuncio, $id, $data);
            }
            $anuncio->save();

            $anuncio->endereco()->update($data['endereco']);

            if (isset($data['anuncio_condicao_comercial']))
                $this->createCondicao($anuncio, $data);

            if (isset($data['caracteristicas']))
                $anuncio->caracteristicas()->sync($data['caracteristicas']);

            if (isset($data['telefones'])) {
                if(isset($data['telefones']['data']))
                foreach ($data['telefones']['ddd'] as $key => $ddd) {
                    Telefone::where('id', $data['telefones']['id'][$key])
                        ->update([
                            'ddd' => $ddd,
                            'numero' => $data['telefones']['numero'][$key],
                            'principal' => $data['telefones']['principal'][$key],
                            'tipo' => $data['telefones']['tipo'][$key],
                        ]);
                    /*$anuncio->telefones()->create([
                        'ddd'=>$ddd,
                        'numero'=>$data['telefones']['numero'][$key],
                        'principal'=>$data['telefones']['principal'][$key],
                        'tipo'=>$data['telefones']['tipo'][$key],
                    ]);*/
                }
            }

            \DB::commit();
            return $this->parserResult($this->generateSlug($anuncio));
        } catch (\Exception $e) {
            \DB::rollback();
            return $e->getMessage();
        }
    }

    private function salvarPreco(&$model, $id, $data)
    {
        $model->preco()->save(AnuncioPreco::create([
            'anuncio_id' => $id,
            'valor' => $data['valor'],
            'valor_condominio' => floatval($data['valor_condominio']),
        ]));
    }

    private function createCondicao(&$model, $data)
    {
        if (is_null($model->concicaoComercial)) {
            $data['anuncio_condicao_comercial']['anuncio_id'] = $model->id;
            $model->concicaoComercial()->save(AnuncioCondicaoComercial::create($data['anuncio_condicao_comercial']));
            return;
        }
        $model->concicaoComercial()->update($data['anuncio_condicao_comercial']);
    }

    public function findByAtivo($slug)
    {
        $anuncio = $this->skipPresenter(true)->findWhere([
            'slug' => $slug,
            'status' => Anuncio::STATUS_ATIVO
        ]);
        if ($anuncio->count() == 0) {
            return null;
        }
        return $this->skipPresenter(false)->parserResult($anuncio->first());
    }

    public function findByUser($slug, $userId = null)
    {
        $anuncio = $this->skipPresenter(true)->findWhere([
            'slug' => $slug,
            'user_id' => $userId
        ]);
        if ($anuncio->count() == 0) {
            return null;
        }
        return $this->skipPresenter(false)->parserResult($anuncio->first());
    }

    public function contagemAnunciosFree($userId)
    {
        $this->withCount();
    }
}
