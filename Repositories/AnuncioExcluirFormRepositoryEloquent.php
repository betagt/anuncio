<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioExcluirFormRepository;
use Modules\Anuncio\Models\AnuncioExcluirForm;

/**
 * Class AnuncioExcluirFormRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioExcluirFormRepositoryEloquent extends BaseRepository implements AnuncioExcluirFormRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioExcluirForm::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
