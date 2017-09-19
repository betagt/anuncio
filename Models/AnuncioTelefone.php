<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Modules\Anuncio\Models\AnuncioTelefone
 *
 * @property int $id
 * @property int $anuncio_id
 * @property int $telefone_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioTelefone whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioTelefone whereAnuncioId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioTelefone whereTelefoneId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioTelefone whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioTelefone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\AnuncioTelefone whereDeletedAt($value)
 * @mixin \Eloquent
 */
class AnuncioTelefone extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
