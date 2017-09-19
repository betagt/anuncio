<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Modules\Anuncio\Models\Caracteristica
 *
 * @property int $id
 * @property string $titulo
 * @property string $tipo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\Caracteristica whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\Caracteristica whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\Caracteristica whereTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\Caracteristica whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\Caracteristica whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Modules\Anuncio\Models\Caracteristica whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Caracteristica extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['titulo','tipo'];

    const TIPO = [
        'Comum'=>'Comum', 'Privativa'=>'Privativa'
    ];

    public function getTipoLabel(){

        if(is_null($this->tipo))
            return null;

        return self::TIPO[$this->tipo];
    }
}
