<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Models\LogPesquisa;

/**
 * Class LogPesquisaTransformer
 * @package namespace Portal\Transformers;
 */
class LogPesquisaTransformer extends TransformerAbstract
{

	/**
	 * Transform the \LogPesquisa entity
	 * @param \Modules\Anuncio\Models\LogPesquisa $model
	 *
	 * @return array
	 */
	public function transform(LogPesquisa $model)
	{
		$result = [
			'pesquisa' => (string)$model->pesquisa,
			'contagem' => ($model->contagem)?$model->contagem:0,
		];
		if($model->id){
			$result = array_merge($result, [
				'id' => (int)$model->id,
				'created_at' => $model->created_at,
				'updated_at' => $model->updated_at
			]);
		}
		return $result;
	}
}
