<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\DadosAnuncianteRepository;
use Modules\Anuncio\Models\DadosAnunciante;
use Modules\Anuncio\Validators\DadosAnuncianteValidator;

/**
 * Class DadosAnuncianteRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class DadosAnuncianteRepositoryEloquent extends BaseRepository implements DadosAnuncianteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DadosAnunciante::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
