<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\FinalidadeCaracteristicaRepository;
use Modules\Anuncio\Models\FinalidadeCaracteristica;
use Modules\Anuncio\Validators\FinalidadeCaracteristicaValidator;

/**
 * Class FinalidadeCaracteristicaRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class FinalidadeCaracteristicaRepositoryEloquent extends BaseRepository implements FinalidadeCaracteristicaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FinalidadeCaracteristica::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
