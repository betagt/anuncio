<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Presenters\MensagemAnuncioPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\MensagemAnuncioRepository;
use Modules\Anuncio\Models\MensagemAnuncio;
use Modules\Anuncio\Validators\MensagemAnuncioValidator;

/**
 * Class MensagemAnuncioRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class MensagemAnuncioRepositoryEloquent extends BaseRepository implements MensagemAnuncioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MensagemAnuncio::class;
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
        return MensagemAnuncioPresenter::class;
    }
}
