<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Modules\Anuncio\Models\AnuncioAcesso
 *
 * @property int $id
 * @property int $anuncio_id
 * @property string $acesso_tipo
 * @property string $adicional
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioAcesso whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioAcesso whereAnuncioId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioAcesso whereAcessoTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioAcesso whereAdicional($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioAcesso whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioAcesso whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioAcesso whereDeletedAt($value)
 * @mixin \Eloquent
 */
class AnuncioAcesso extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
