<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Models\AnuncioImovel;

/**
 * Class AnuncioImovelTransformer
 * @package namespace Modules\Anuncio\Transformers;
 */
class AnuncioImovelTransformer extends TransformerAbstract
{

    /**
     * Transform the \AnuncioImovel entity
     * @param \AnuncioImovel $model
     *
     * @return array
     */
    public function transform(AnuncioImovel $model)
    {
        return [
            #'anuncio_id'                    => (int) $model->anuncio_id,
            'area_util'                     => (float) $model->area_util,
            'area_total'                    => (float) $model->area_total,
            'qtde_dormitorio'               => (int) $model->qtde_dormitorio,
            'qtde_suite'                    => (int) $model->qtde_suite,
            'qtde_banheiro'                 => (int) $model->qtde_banheiro,
            'qtde_vaga'                     => (int) $model->qtde_vaga,
            'qtde_sala'                     => (int) $model->qtde_sala,
            'possui_divida'                 => (boolean) $model->possui_divida,
            'saldo_divida'                  => (float) $model->saldo_divida,
            'valor_mensalidade_divida'      => (float) $model->valor_mensalidade_divida,
            'data_vencimento_divida'        =>  $model->data_vencimento_divida,
            'data_ultima_parcela_divida'    =>  $model->data_ultima_parcela_divida,
            'qtde_parcela_restante_divida'  =>  $model->qtde_parcela_restante_divida,

            /*'created_at' => $model->created_at,
            'updated_at' => $model->updated_at*/
        ];
    }
}
