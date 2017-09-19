<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface FinalidadeRepository
 * @package namespace Modules\Anuncio\Repositories;
 */
interface FinalidadeRepository extends RepositoryInterface
{
   public function createByCarateristica(array $data);
   public function updateByCarateristica(array $data, $id);
}
