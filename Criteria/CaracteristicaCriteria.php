<?php


namespace Modules\Anuncio\Criteria;


use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FormaPgtoCriteria
 * @package namespace Modules\Anuncio\Criteria;
 */
class CaracteristicaCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
        'caracteristicas.titulo'=>'ilike',
        'caracteristicas.tipo'=>'ilike',
    ];
}