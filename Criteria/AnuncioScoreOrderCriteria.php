<?php

namespace Modules\Anuncio\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AnuncioScoreOrderCriteria
 * @package namespace Portal\Criteria;
 */
class AnuncioScoreOrderCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->orderBy('score', 'desc');
        return $model;
    }
}
