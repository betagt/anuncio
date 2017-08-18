<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\ScoreRepository;
use Modules\Anuncio\Models\Score;
use Modules\Anuncio\Validators\ScoreValidator;

/**
 * Class ScoreRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class ScoreRepositoryEloquent extends BaseRepository implements ScoreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Score::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
