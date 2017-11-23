<?php


namespace Modules\Anuncio\Criteria;


use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FormaPgtoCriteria
 * @package namespace Modules\Anuncio\Criteria;
 */
class PesquisaCriteria extends BaseCriteria implements CriteriaInterface
{
	protected $filterCriteria = [
		'log_pesquisas.created_at' => 'between'
	];

	public function apply($model, RepositoryInterface $repository)
	{
		$model = parent::apply($model, $repository);
		$model = $model
			->select(['public.log_pesquisas.pesquisa',\DB::raw('count(public.log_pesquisas.pesquisa) as contagem')])
			->groupby(['log_pesquisas.pesquisa'])
			->distinct();
		return $model;
	}
}