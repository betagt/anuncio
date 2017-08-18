<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Models\MensagemAnuncio;

/**
 * Class MensagemAnuncioTransformer
 * @package namespace Modules\Anuncio\Transformers;
 */
class MensagemAnuncioTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['anuncio'];
    /**
     * Transform the \MensagemAnuncio entity
     * @param \MensagemAnuncio $model
     *
     * @return array
     */
    public function transform(MensagemAnuncio $model)
    {
        return [
            'id'         => (int) $model->id,
            'anuncio_id'         => (int) $model->anuncio_id,
            'nome'         => (string) $model->nome,
            'email'         => (string) $model->email,
            'ddd'         => (string) $model->ddd,
            'telefone'         => (string) $model->telefone,
            'texto'         => (string) $model->texto,
            'status'         => (boolean) $model->status,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeAnuncio(MensagemAnuncio $model){
        if(is_null($model->anuncio)){
            return null;
        }
        return $this->item($model->anuncio, new AnuncioTransformer());
    }
}
