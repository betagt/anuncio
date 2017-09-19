<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Models\AnuncioCondicaoComercial;

/**
 * Class AnuncioCondicaoComercialTransformer
 * @package namespace Modules\Anuncio\Transformers;
 */
class AnuncioCondicaoComercialTransformer extends TransformerAbstract
{

    /**
     * Transform the \AnuncioCondicaoComercial entity
     * @param \AnuncioCondicaoComercial $model
     *
     * @return array
     */
    public function transform(AnuncioCondicaoComercial $model)
    {
        return [
            'id'                    => (int) $model->id,
            'anuncio_id'            => (int) $model->anuncio_id,
            'aceita_permuta'        => (boolean) $model->aceita_permuta,
            'aceita_permuta_carro'  => (boolean) $model->aceita_permuta_carro,
            'aceita_permuta_imovel' => (boolean) $model->aceita_permuta_imovel,
            'aceita_permuta_outro'  => (boolean) $model->aceita_permuta_outro,
            'valor_permuta_carro'   => (double) $model->valor_permuta_carro,
            'valor_permuta_imovel'  => (double) $model->valor_permuta_imovel,
            'valor_permuta_outro'   => (double) $model->valor_permuta_outro,
            'valor_permuta_outro_descricao'   => (string) $model->valor_permuta_outro_descricao,
            'descricao_permuta'     => (string) $model->descricao_permuta,
            'valor_mensal'          => (double) $model->valor_mensal,
            'valor_entrada'         => (double) $model->valor_entrada,
            'created_at'            => $model->created_at,
            'updated_at'            => $model->updated_at
        ];
    }
}
