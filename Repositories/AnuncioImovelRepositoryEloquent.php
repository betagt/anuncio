<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Presenters\AnuncioImovelPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioImovelRepository;
use Modules\Anuncio\Models\AnuncioImovel;
use Modules\Anuncio\Validators\AnuncioImovelValidator;

/**
 * Class AnuncioImovelRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioImovelRepositoryEloquent extends BaseRepository implements AnuncioImovelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioImovel::class;
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
        return AnuncioImovelPresenter::class;
    }
}
