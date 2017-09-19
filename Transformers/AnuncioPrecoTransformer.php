<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Models\AnuncioPreco;

/**
 * Class AnuncioPrecoTransformer
 * @package namespace Modules\Anuncio\Transformers;
 */
class AnuncioPrecoTransformer extends TransformerAbstract
{

    /**
     * Transform the \AnuncioPreco entity
     * @param \AnuncioPreco $model
     *
     * @return array
     */
    public function transform(AnuncioPreco $model)
    {
        return [
            'id'         => (int) $model->id,
            'anuncio_id'         => (int) $model->anuncio_id,
            'valor'         => (float) $model->valor,
            'valor_condominio'         => (float) $model->valor_condominio,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
