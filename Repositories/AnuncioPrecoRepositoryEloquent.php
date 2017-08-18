<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Presenters\AnuncioPrecoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioPrecoRepository;
use Modules\Anuncio\Models\AnuncioPreco;
use Modules\Anuncio\Validators\AnuncioPrecoValidator;

/**
 * Class AnuncioPrecoRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioPrecoRepositoryEloquent extends BaseRepository implements AnuncioPrecoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioPreco::class;
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
        return AnuncioPrecoPresenter::class;
    }
}
