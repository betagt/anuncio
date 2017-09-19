<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Modules\Anuncio\Models\AnuncioEmpreendimento
 *
 * @property int $anuncio_id
 * @property string $titulo
 * @property string $titulo_reduzido
 * @property string $subtitulo
 * @property string $descricao_curta
 * @property int $qtde_area_maximo
 * @property int $qtde_area_minimo
 * @property int $qtde_dormitoario_maximo
 * @property int $qtde_dormitoario_minimo
 * @property int $qtde_suite_maximo
 * @property int $qtde_suite_minimo
 * @property int $qtde_andar
 * @property int $qtde_elevador
 * @property int $qtde_unidade_andar
 * @property string $tour_virtual
 * @property string $video
 * @property string $informacao_complementar
 * @property string $descricao_localizacao
 * @property string $situacao
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereAnuncioId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereTituloReduzido($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereSubtitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereDescricaoCurta($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeAreaMaximo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeAreaMinimo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeDormitoarioMaximo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeDormitoarioMinimo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeSuiteMaximo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeSuiteMinimo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeAndar($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeElevador($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereQtdeUnidadeAndar($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereTourVirtual($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereVideo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereInformacaoComplementar($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereDescricaoLocalizacao($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereSituacao($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioEmpreendimento whereDeletedAt($value)
 * @mixin \Eloquent
 */
class AnuncioEmpreendimento extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
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

    public function anuncio(){
        return $this->morphOne(Anuncio::class,'anunciotable');
    }
}
