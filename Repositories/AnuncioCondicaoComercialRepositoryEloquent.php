<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Presenters\AnuncioCondicaoComercialPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioCondicaoComercialRepository;
use Modules\Anuncio\Models\AnuncioCondicaoComercial;
use Modules\Anuncio\Validators\AnuncioCondicaoComercialValidator;

/**
 * Class AnuncioCondicaoComercialRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioCondicaoComercialRepositoryEloquent extends BaseRepository implements AnuncioCondicaoComercialRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioCondicaoComercial::class;
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
        return AnuncioCondicaoComercialPresenter::class;
    }
}
