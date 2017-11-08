<?php

namespace Modules\Anuncio\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Transformers\UserTransformer;
use Modules\Localidade\Transformers\EnderecoTransformer;
use Modules\Localidade\Transformers\TelefoneTransformer;
use Modules\Anuncio\Models\Anuncio;
use Modules\Plano\Models\PlanoContratacao;
use Modules\Plano\Repositories\PlanoContratacaoRepository;
use Modules\Plano\Transformers\PlanoContratacaoTransformer;
use Portal\Transformers\ImagemTransformer;

/**
 * Class AnuncioTransformer
 * @package namespace Modules\Anuncio\Transformers;
 */
class AnuncioTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'anunciante',
        'finalidade',
        'endereco',
        'preco',
        'imagens',
        'condicao_comercial',
        'caracteristicas',
        'telefones'
    ];

    /**
     * Transform the \Anuncio entity
     * @param \Anuncio $model
     *
     * @return array
     */
    public function transform(Anuncio $model)
    {
        $contratacao = ($model->houvecontratacao->count() > 0) ? $model->houvecontratacao->first() : null;
        $json = [
            'id' => (int)$model->id,
            'pretensao' => (string)$model->pretensao,
            'slug' => (string)$model->slug,
            'imagem_principal' => $model->imagemPrincipal(),
            'banner' => ($model->banner) ? \URL::to('/') . '/arquivos/img/anuncio/' . $model->banner : null,
            'codigo' => (string)$model->codigo,
            'descricao' => (string)$model->descricao,
            'ano_construcao' => (int)$model->ano_construcao,
            'finalidade_id' => (int)$model->finalidade_id,
            'user_id' => (int)$model->user_id,
            'telefone' => (string)!is_null($model->telefone) ? "({$model->telefone->ddd}) {$model->telefone->numero}" : null,
            'valor' => (double)$model->valor,
            'valor_condominio' => (double)$model->valor_condominio,
            'iptu' => (double)$model->iptu,
            'valor_condominio_isento' => (boolean)$model->valor_condominio_isento,
            'observacao' => (string)$model->observacao,
            'houvecontratacao' => (boolean)($model->houvecontratacao->count() > 0) ? true : false,
            'caracteristica_extra' => (string)$model->caracteristica_extra,
            'latitude' => (double)$model->latitude,
            'longitude' => (double)$model->longitude,
            'tipo' => (string)$model->tipo,
            'video' => (string)$model->video,
            'anunciante_nome' => (string)($model->user) ? $model->user->name : null,

            'titulo' => (string)$model->titulo,
            'titulo_reduzido' => (string)$model->titulo_reduzido,
            'subtitulo' => (string)$model->subtitulo,
            'descricao_curta' => (string)$model->descricao_curta,
            'qtde_area_minimo' => (double)$model->qtde_area_minimo,
            'qtde_area_maximo' => (double)$model->qtde_area_maximo,
            'qtde_dormitoario_minimo' => (int)$model->qtde_dormitoario_minimo,
            'qtde_dormitoario_maximo' => (int)$model->qtde_dormitoario_maximo,
            'qtde_suite_minimo' => (int)$model->qtde_suite_minimo,
            'qtde_suite_maximo' => (int)$model->qtde_suite_maximo,
            'qtde_andar' => (int)$model->qtde_andar,
            'qtde_elevador' => (int)$model->qtde_elevador,
            'qtde_unidade_andar' => (int)$model->qtde_unidade_andar,
            'anuncio_mapa_confirm' => (boolean)$model->anuncio_mapa_confirm,
            'situacao' => (string) $model->situacao,

            'area_util' => (float)$model->area_util,
            'area_total' => (float)$model->area_total,
            'qtde_dormitorio' => (int)$model->qtde_dormitorio,
            'qtde_suite' => (int)$model->qtde_suite,
            'qtde_banheiro' => (int)$model->qtde_banheiro,
            'qtde_vaga' => (int)$model->qtde_vaga,
            'qtde_sala' => (int)$model->qtde_sala,
            'possui_divida' => (boolean)$model->possui_divida,
            'saldo_divida' => (float)$model->saldo_divida,
            'valor_mensalidade_divida' => (float)$model->valor_mensalidade_divida,
            'data_vencimento_divida' => $model->data_vencimento_divida,
            'data_ultima_parcela_divida' => $model->data_ultima_parcela_divida,
            'qtde_parcela_restante_divida' => $model->qtde_parcela_restante_divida,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
            'status' => (boolean)$model->status,
            'novo' => (boolean)$model->novo,
            'valor_promocional' => (float)$model->valor_promocional,
        ];

        if ($contratacao) {
            $json = array_merge($json, [
                'contratacao_ativa' => ($contratacao->status == PlanoContratacao::STATUS_ATIVO) ? true : false,
                'contratacao_label' => $contratacao->status,
                'plano' => $contratacao->plano->nome,
                'forma_pagamento' => ($contratacao->ultimoLancamentoPago->count() > 0) ? $contratacao->ultimoLancamentoPago->first()->metodo : null,
                'contratacao_codigo' => $contratacao->id,
                'data_inicio' => $contratacao->data_inicio,
                'data_fim' => $contratacao->data_fim,
                'total' => (double)$contratacao->total,
            ]);
        }

        return $json;
    }

    public function includeAnuncioImovel(Anuncio $model)
    {
        if (!$model->anuncioImovel) {
            return null;
        }
        return $this->item($model->anuncioImovel, new AnuncioImovelTransformer());
    }

    public function includeFinalidade(Anuncio $model)
    {
        if (!$model->finalidade) {
            return null;
        }
        return $this->item($model->finalidade, new FinalidadeTransformer());
    }

    public function includeEndereco(Anuncio $model)
    {
        if (!$model->endereco) {
            return null;
        }
        return $this->item($model->endereco, new EnderecoTransformer());
    }

    public function includePreco(Anuncio $model)
    {
        if (!$model->preco) {
            return null;
        }
        return $this->item($model->getValorAtivo(), new AnuncioPrecoTransformer());
    }

    public function includeImagens(Anuncio $model)
    {
        if (!$model->imagens) {
            return null;
        }
        return $this->collection($model->imagens, new ImagemTransformer());
    }

    public function includeTelefones(Anuncio $model)
    {
        if (!$model->telefones) {
            return null;
        }
        return $this->collection($model->telefones, new TelefoneTransformer());
    }

    public function includeCondicaoComercial(Anuncio $model)
    {
        if (is_null($model->concicaoComercial)) {
            return null;
        }
        return $this->item($model->concicaoComercial, new AnuncioCondicaoComercialTransformer());
    }

    public function includeCaracteristicas(Anuncio $model)
    {
        if (is_null($model->caracteristicas)) {
            return null;
        }
        return $this->collection($model->caracteristicas, new CaracteristicaTransformer());
    }

    public function includeAnunciante(Anuncio $model)
    {
        if (is_null($model->user)) {
            return null;
        }
        return $this->item($model->user, new UserTransformer());
    }

}
