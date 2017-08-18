<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\DadosAnuncianteContatoRepository;
use Modules\Anuncio\Models\DadosAnuncianteContato;
use Modules\Anuncio\Validators\DadosAnuncianteContatoValidator;

/**
 * Class DadosAnuncianteContatoRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class DadosAnuncianteContatoRepositoryEloquent extends BaseRepository implements DadosAnuncianteContatoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DadosAnuncianteContato::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
