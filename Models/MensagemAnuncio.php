<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class MensagemAnuncio extends Model implements Transformable
{
    use TransformableTrait,SoftDeletes;

    protected $fillable = [
        'anuncio_id',
        'nome',
        'email',
        'ddd',
        'telefone',
        'texto',
    ];

    public function anuncio(){
        return $this->belongsTo(Anuncio::class,'anuncio_id');
    }
}
