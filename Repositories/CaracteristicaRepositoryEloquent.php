<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Presenters\CaracteristicaPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\CaracteristicaRepository;
use Modules\Anuncio\Models\Caracteristica;
use Modules\Anuncio\Validators\CaracteristicaValidator;

/**
 * Class CaracteristicaRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class CaracteristicaRepositoryEloquent extends BaseRepository implements CaracteristicaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Caracteristica::class;
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
        return CaracteristicaPresenter::class;
    }
}
