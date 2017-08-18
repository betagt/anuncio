<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioImagemRepository;
use Modules\Anuncio\Models\AnuncioImagem;
use Modules\Anuncio\Validators\AnuncioImagemValidator;

/**
 * Class AnuncioImagemRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioImagemRepositoryEloquent extends BaseRepository implements AnuncioImagemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioImagem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
