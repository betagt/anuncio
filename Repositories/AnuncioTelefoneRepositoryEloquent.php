<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\AnuncioTelefoneRepository;
use Modules\Anuncio\Models\AnuncioTelefone;
use Modules\Anuncio\Validators\AnuncioTelefoneValidator;

/**
 * Class AnuncioTelefoneRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioTelefoneRepositoryEloquent extends BaseRepository implements AnuncioTelefoneRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnuncioTelefone::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
