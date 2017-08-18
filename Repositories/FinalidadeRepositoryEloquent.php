<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Presenters\FinalidadePresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\FinalidadeRepository;
use Modules\Anuncio\Models\Finalidade;
use Modules\Anuncio\Validators\FinalidadeValidator;

/**
 * Class FinalidadeRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class FinalidadeRepositoryEloquent extends BaseRepository implements FinalidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Finalidade::class;
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
        return FinalidadePresenter::class;
    }

    public function createByCarateristica(array $data)
    {
        $finalidade = $this->skipPresenter(true)->create($data);
        if(isset($data['caracteristicas']))
            $finalidade->caracteristicas()->sync($data['caracteristicas']);

        return $this->parserResult($finalidade);
    }

    public function updateByCarateristica(array $data, $id)
    {
        $finalidade = $this->model->findOrFail($id);
        $finalidade->fill($data);
        $finalidade->save();
        if(isset($data['caracteristicas']))
            $finalidade->caracteristicas()->sync($data['caracteristicas']);

        return $this->parserResult($finalidade);
    }
}
