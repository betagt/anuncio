<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Modules\Anuncio\Models\AnuncioCondicaoComercial
 *
 * @property int $id
 * @property int $anuncio_id
 * @property bool $aceita_permuta
 * @property bool $aceita_permuta_carro
 * @property bool $aceita_permuta_imovel
 * @property bool $aceita_permuta_outro
 * @property float $valor_permuta_carro
 * @property float $valor_permuta_imovel
 * @property float $valor_permuta_outro
 * @property string $descricao_permuta
 * @property float $valor_mensal
 * @property float $valor_entrada
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereAnuncioId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereAceitaPermuta($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereAceitaPermutaCarro($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereAceitaPermutaImovel($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereAceitaPermutaOutro($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereValorPermutaCarro($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereValorPermutaImovel($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereValorPermutaOutro($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereDescricaoPermuta($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereValorMensal($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereValorEntrada($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioCondicaoComercial whereDeletedAt($value)
 * @mixin \Eloquent
 */
class AnuncioCondicaoComercial extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'anuncio_id',
        'aceita_permuta',
        'aceita_permuta_carro',
        'aceita_permuta_imovel',
        'aceita_permuta_outro',
        'valor_permuta_carro',
        'valor_permuta_imovel',
        'valor_permuta_outro',
        'descricao_permuta',
        'valor_mensal',
        'valor_entrada',
    ];

}
