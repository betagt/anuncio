<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Models\Finalidade;

/**
 * Class FinalidadeTransformer
 * @package namespace Modules\Anuncio\Transformers;
 */
class FinalidadeTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['caracteristicas'];

    /**
     * Transform the \Finalidade entity
     * @param \Finalidade $model
     *
     * @return array
     */
    public function transform(Finalidade $model)
    {
        return [
            'id'         => (int) $model->id,
            'parent_id'         => (int) $model->parent_id,
            'titulo'         => (string) $model->titulo,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeCaracteristicas(Finalidade $model){
        if(is_null($model->caracteristicas)){
            return null;
        }
        return $this->collection($model->caracteristicas, new CaracteristicaTransformer());
    }
}
