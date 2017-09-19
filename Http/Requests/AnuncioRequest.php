<?php

namespace Modules\Anuncio\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Anuncio\Models\Anuncio;

class AnuncioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($id = null, $tipo = null)
    {

        $rules = [
            'user_id' => 'required',
            'finalidade_id' => [
                'required',
                'integer',
                'exists:finalidades,id'
            ],
            'pretensao' => 'required|in:Alugar,Vender,Revender,Lancamento',
            //'codigo'                =>'unique:anuncios,codigo'.(is_null($id)?'':",$id"),
            'valor' => 'required|numeric|min:0',
            'valor_condominio_validation' => 'boolean',
            'valor_condominio' => 'required_if:valor_condominio_validation,true|min:0|numeric|nullable',
            'descricao' => 'required',
            'tipo' => 'required|in:imovel,empreendimento',
            'caracteristica_extra' => 'json',
            'latitude' => 'numeric|nullable|required_if:anuncio_mapa_confirm,true',
            'longitude' => 'numeric|nullable|required_if:anuncio_mapa_confirm,true',
            'anuncio_mapa_confirm' => 'required|boolean',


            'ano_construcao' => 'nullable',

            'endereco.estado_id' => 'required|exists:estados,id',
            'endereco.cidade_id' => 'required|exists:cidades,id',
            'endereco.bairro_id' => 'required|exists:bairros,id',
            'endereco.cep' => 'required',
            'endereco.numero' => 'required',
            'endereco.endereco' => 'required',

            'anuncio_condicao_comercial' => 'array',
            'anuncio_condicao_comercial.aceita_permuta' => 'boolean',
            'anuncio_condicao_comercial.aceita_permuta_carro' => 'boolean',
            'anuncio_condicao_comercial.aceita_permuta_imovel' => 'boolean',
            'anuncio_condicao_comercial.aceita_permuta_outro' => 'boolean',
            'anuncio_condicao_comercial.valor_permuta_carro' => 'numeric|min:0|required_if:anuncio_condicao_comercial.aceita_permuta_carro,true',
            'anuncio_condicao_comercial.valor_permuta_imovel' => 'numeric|min:0|required_if:anuncio_condicao_comercial.aceita_permuta_imovel,true',
            'anuncio_condicao_comercial.valor_permuta_outro' => 'numeric|min:0|required_if:anuncio_condicao_comercial.aceita_permuta_outro,true',
            'anuncio_condicao_comercial.descricao_permuta' => 'max:800',
            'anuncio_condicao_comercial.valor_mensal' => 'numeric|min:0',
            'anuncio_condicao_comercial.valor_entrada' => 'numeric|min:0',

            'caracteristicas' => 'array|nullable',

            'telefones' => 'array|nullable',
            'telefones.ddd.*' => 'integer|required_if:telefones,array|min:0',
            'telefones.numero.*' => 'max:255|required_if:telefones,array',
            'telefones.principal.*' => 'boolean',
            'telefones.tipo.*' => 'required|in:fixo,fax,celular',
        ];

        if ($id) {
            $rules = array_merge($rules, [
                'telefones.id.*' => 'integer|required_if:telefones,array'
            ]);
        }

        if ($tipo == Anuncio::TYPE_ANUNCIO_IMOVEL) {
            $rules = [
                'area_util' => 'required|numeric|min:0',
                'area_total' => 'numeric|min:0',
                'qtde_dormitorio' => 'required|integer|min:0',
                'qtde_suite' => 'integer|min:0',
                'qtde_banheiro' => 'integer|min:0',
                'qtde_vaga' => 'integer|min:0',
                'qtde_sala' => 'integer|min:0',
                'possui_divida' => 'boolean',
                'saldo_divida' => 'numeric|min:0',
                'valor_mensalidade_divida' => 'numeric|min:0',
                'data_vencimento_divida' => 'date_format:Y-m-d',
                'data_ultima_parcela_divida' => 'date_format:Y-m-d',
                'qtde_parcela_restante_divida' => 'integer|min:0',
            ];
        }


        if ($tipo == Anuncio::TYPE_ANUNCIO_EMPREENDIMENTO) {
            $rules = [
                'titulo' => 'required|max:255',
                'titulo_reduzido' => 'required|max:255',
                'subtitulo' => 'required|max:255',
                'descricao_curta' => 'required|max:500',
                'qtde_area_maximo' => 'required|numeric|min:0',
                'qtde_area_minimo' => 'required|numeric|different:qtde_area_maximo|min:0',
                'qtde_dormitoario_maximo' => 'required|integer|min:0',
                'qtde_dormitoario_minimo' => 'required|integer|different:qtde_dormitoario_maximo|min:0',
                'qtde_suite_maximo' => 'required|integer|min:0',
                'qtde_suite_minimo' => 'required|integer|different:qtde_suite_maximo|min:0',
                'qtde_andar' => 'required|integer|min:0',
                'qtde_elevador' => 'required|integer|min:0',
                'qtde_unidade_andar' => 'integer|min:0',
                'tour_virtual' => 'string:nullable|nullable',
                'video' => 'string:nullable|nullable',
                'informacao_complementar' => 'string:nullable|nullable',
                'descricao_localizacao' => 'string:nullable|nullable',
                'situacao' => 'required|in:na-planta,em-obras,pronto',
            ];
        }
        return $rules;
    }
}
