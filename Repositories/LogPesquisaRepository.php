<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface LogPesquisaRepository
 * @package namespace Portal\Repositories;
 */
interface LogPesquisaRepository extends RepositoryInterface
{
    public function statistica();

    public function contagem();
}
