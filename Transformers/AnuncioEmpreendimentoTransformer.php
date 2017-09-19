<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Models\AnuncioEmpreendimento;

/**
 * Class AnuncioEmpreendimentoTransformer
 * @package namespace Modules\Anuncio\Transformers;
 */
class AnuncioEmpreendimentoTransformer extends TransformerAbstract
{

    /**
     * Transform the \AnuncioEmpreendimento entity
     * @param \AnuncioEmpreendimento $model
     *
     * @return array
     */
    public function transform(AnuncioEmpreendimento $model)
    {
        return [
            'id'         => (int) $model->id,
            'titulo'    =>(string)$model->titulo,
            'titulo_reduzido'    =>(string)$model->titulo_reduzido,
            'subtitulo'    =>(string)$model->subtitulo,
            'descricao_curta'    =>(string)$model->descricao_curta,
            'qtde_area_minimo'    =>(double)$model->qtde_area_minimo,
            'qtde_area_maximo'    =>(double)$model->qtde_area_maximo,
            'qtde_dormitoario_minimo'    =>(int)$model->qtde_dormitoario_minimo,
            'qtde_dormitoario_maximo'    =>(int)$model->qtde_dormitoario_maximo,
            'qtde_suite_minimo'    =>(int)$model->qtde_suite_minimo,
            'qtde_suite_maximo'    =>(int)$model->qtde_suite_maximo,
            'qtde_andar'    =>(int)$model->qtde_andar,
            'qtde_elevador'    =>(int)$model->qtde_elevador,
            'qtde_unidade_andar'    =>(int)$model->qtde_unidade_andar,
            'situacao'    =>(string)$model->situacao,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
