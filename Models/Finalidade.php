<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Finalidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['parent_id','titulo', 'bloqueado'];

    public function caracteristicas(){
        return $this->belongsToMany(Caracteristica::class, 'finalidade_caracteristicas', 'finalidade_id', 'caracteristica_id');
    }
}
