<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioAcessoRepository;
use Modules\Anuncio\Models\AnuncioAcesso;
use Modules\Anuncio\Validators\AnuncioAcessoValidator;

/**
 * Class AnuncioAcessoRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioAcessoRepositoryEloquent extends BaseRepository implements AnuncioAcessoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioAcesso::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
