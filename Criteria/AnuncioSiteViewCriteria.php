<?php

namespace Modules\Anuncio\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;


/**
 * Class MensagemAnuncioCriteria
 * @package namespace Portal\Criteria;
 */
class AnuncioSiteViewCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('remove_site_view', 'is', null);
    }
}
