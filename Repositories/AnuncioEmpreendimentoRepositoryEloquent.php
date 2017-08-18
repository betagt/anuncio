<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Presenters\AnuncioEmpreendimentoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioEmpreendimentoRepository;
use Modules\Anuncio\Models\AnuncioEmpreendimento;
use Modules\Anuncio\Validators\AnuncioEmpreendimentoValidator;

/**
 * Class AnuncioEmpreendimentoRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioEmpreendimentoRepositoryEloquent extends BaseRepository implements AnuncioEmpreendimentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioEmpreendimento::class;
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
        return AnuncioEmpreendimentoPresenter::class;
    }
}
