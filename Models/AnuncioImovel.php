<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Modules\Anuncio\Models\AnuncioImovel
 *
 * @property int $anuncio_id
 * @property float $area_util
 * @property float $area_total
 * @property int $qtde_dormitorio
 * @property int $qtde_suite
 * @property int $qtde_banheiro
 * @property int $qtde_vaga
 * @property int $qtde_sala
 * @property bool $possui_divida
 * @property float $saldo_divida
 * @property float $valor_mensalidade_divida
 * @property string $data_vencimento_divida
 * @property string $data_ultima_parcela_divida
 * @property int $qtde_parcela_restante_divida
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereAnuncioId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereAreaUtil($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereAreaTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereQtdeDormitorio($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereQtdeSuite($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereQtdeBanheiro($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereQtdeVaga($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereQtdeSala($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel wherePossuiDivida($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereSaldoDivida($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereValorMensalidadeDivida($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereDataVencimentoDivida($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereDataUltimaParcelaDivida($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereQtdeParcelaRestanteDivida($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioImovel whereDeletedAt($value)
 * @mixin \Eloquent
 */
class AnuncioImovel extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'anuncio_id',
        'area_util',
        'area_total',
        'qtde_dormitorio',
        'qtde_suite',
        'qtde_banheiro',
        'qtde_vaga',
        'possui_divida',
        'saldo_divida',
        'valor_mensalidade_divida',
        'data_vencimento_divida',
        'data_ultima_parcela_divida',
        'qtde_parcela_restante_divida',
        'titulo',
        'titulo_reduzido',
        'subtitulo',
        'descricao_curta',
        'qtde_area_minimo',
        'qtde_area_maximo',
        'qtde_dormitoario_minimo',
        'qtde_dormitoario_maximo',
        'qtde_suite_minimo',
        'qtde_suite_maximo',
        'qtde_andar',
        'qtde_elevador',
        'qtde_unidade_andar',
        'situacao'
    ];

}
