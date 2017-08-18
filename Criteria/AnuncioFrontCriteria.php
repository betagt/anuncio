<?php

namespace Modules\Anuncio\Criteria;

use Illuminate\Http\Request;
use Portal\Criteria\BaseCriteria;
use Portal\Models\Anuncio;
use Portal\Models\AnuncioEmpreendimento;
use Portal\Models\AnuncioImovel;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AnuncioCriteria
 * @package namespace Portal\Criteria;
 */
class AnuncioFrontCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
        'anuncios.id'               =>'=',
        'anuncios.codigo'           =>'=',
        'anuncios.pretensao'        =>'=',
        'anuncios.finalidade_id'    =>'=',
        'anuncios.cidade_id'        =>'=',
        'anuncios.user_id'          =>'=',
        'anuncios.estado_id'        =>'=',
        'anuncios.bairro_id'        =>'=',
        'anuncios.tipo'             =>'=',
        'anuncios.situacao'         =>'=',
        'anuncios.ano_construcao'   =>'=',
        'anuncios.possui_divida'    =>'=',
        'anuncios.qtde_banheiro'    =>'in',
        'anuncios.qtde_andar'       =>'in',
        'anuncios.qtde_elevador'    =>'in',
        'anuncios.qtde_unidade_andar'=>'in',
        'anuncios.qtde_vaga'        =>'in',
        'anuncios.qtde_sala'        =>'in',
        'anuncios.saldo_divida'     =>'between',
        'anuncios.valor_mensalidade_divida'=>'between',
        'anuncios.valor'            =>'between',
        'anuncios.valor_condominio' =>'between',
        'anuncios.qtde_parcela_restante_divida' =>'between',
        'anuncio_condicao_comercials.aceita_permuta' => '=',
        'anuncio_condicao_comercials.aceita_permuta_carro' => '=',
        'anuncio_condicao_comercials.aceita_permuta_imovel' => '=',
        'anuncio_condicao_comercials.aceita_permuta_outro' => '=',
        'anuncio_condicao_comercials.valor_permuta_carro' => 'between',
        'anuncio_condicao_comercials.valor_permuta_imovel' => 'between',
        'anuncio_condicao_comercials.valor_permuta_outro' => 'between',
        'anuncio_condicao_comercials.valor_mensal' => 'between',
        'anuncio_condicao_comercials.valor_entrada' => 'between',
        'enderecos.cep'             =>'=',
        'cidades.titulo'            =>'like',
        'estados.titulo'            =>'like',
        'estados.uf'                =>'like',
        'finalidades.titulo'        =>'like',
    ];

    protected $filterCriteriaOr = [
        [
            'elements'=>[
                'anuncios.qtde_dormitorio',
                'anuncios.qtde_dormitoario_minimo',
                'anuncios.qtde_dormitoario_maximo',
            ],
            'condition'=>'in'
        ],
        [
            'elements'=>[
                'anuncios.qtde_suite',
                'anuncios.qtde_suite_minimo',
                'anuncios.qtde_suite_maximo',
            ],
            'condition'=>'in'
        ],
        [
            'elements'=>[
                'anuncios.area_util',
                'anuncios.qtde_area_minimo',
                'anuncios.qtde_area_maximo',
            ],
            'condition'=>'between'
        ]
    ];
    /**
     * @var
     */
    private $userId;

    public function __construct(Request $request, $userId)
    {

        parent::__construct($request);
        $this->userId = $userId;
    }

    public function apply($model, RepositoryInterface $repository){
        $model = parent::apply($model, $repository);
        return $model
            ->leftJoin('enderecos',function ($join){
                $join->on('anuncios.id', '=', 'enderecos.enderecotable_id');
                $join->where('enderecos.enderecotable_type','=', \Modules\Anuncio\Models\Anuncio::class);
            })
            ->leftJoin('anuncio_condicao_comercials','anuncios.id', 'anuncio_condicao_comercials.anuncio_id')
            ->join('finalidades','anuncios.finalidade_id','finalidades.id')
            ->leftJoin('cidades','enderecos.cidade_id','cidades.id')
            ->leftJoin('estados','enderecos.estado_id','estados.id')
            ->leftJoin('bairros','enderecos.bairro_id','bairros.id')
            ->where('anuncios.user_id','=',$this->userId)
            ->select(array_merge($this->defaultTable));
    }
}
