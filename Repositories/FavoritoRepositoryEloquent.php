<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\FavoritoRepository;
use Modules\Anuncio\Models\Favorito;
use Modules\Anuncio\Validators\FavoritoValidator;

/**
 * Class FavoritoRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class FavoritoRepositoryEloquent extends BaseRepository implements FavoritoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Favorito::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
