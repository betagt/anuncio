<?php


namespace Modules\Anuncio\Criteria;


use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FormaPgtoCriteria
 * @package namespace Modules\Anuncio\Criteria;
 */
class FinalidadeCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
        'finalidades.id'=>'=',
        'finalidades.parent_id'=>'=',
        'finalidades.titulo'=>'ilike'
    ];
}