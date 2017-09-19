<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Models\Caracteristica;

/**
 * Class CaracteristicaTransformer
 * @package namespace Modules\Anuncio\Transformers;
 */
class CaracteristicaTransformer extends TransformerAbstract
{

    /**
     * Transform the \Caracteristica entity
     * @param \Caracteristica $model
     *
     * @return array
     */
    public function transform(Caracteristica $model)
    {
        return [
            'id'         => (int) $model->id,
            'titulo'     => (string) $model->titulo,
            'tipo'       => (string) $model->tipo,
            'tipo_label'       => (string) $model->getTipoLabel(),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
