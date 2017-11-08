<?php

namespace Modules\Anuncio\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AnuncioRepository
 * @package namespace Modules\Anuncio\Repositories;
 */
interface AnuncioRepository extends RepositoryInterface
{
    public function createByEnderecoPreco(array $data);
    public function updateByEnderecoPreco(array $data, $id);
    public function findByAtivo($slug);
    public function findByUser($id, $userId=null);
    public function limitByPretensao ($pretencao,array $query, $limit);
    public function ultimosBylimit (array $query, $limit);
    public function contagemAnunciosFree($userId);
}
