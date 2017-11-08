<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Anuncio\Repositories\DenunciaRepository;
use Modules\Anuncio\Models\Denuncia;
use Portal\Validators\DenunciaValidator;

/**
 * Class DenunciaRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class DenunciaRepositoryEloquent extends BaseRepository implements DenunciaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Denuncia::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
