<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioCaracteristicaRepository;
use Modules\Anuncio\Models\AnuncioCaracteristica;
use Modules\Anuncio\Validators\AnuncioCaracteristicaValidator;

/**
 * Class AnuncioCaracteristicaRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioCaracteristicaRepositoryEloquent extends BaseRepository implements AnuncioCaracteristicaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioCaracteristica::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
