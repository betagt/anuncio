<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class AnuncioExcluirForm extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'anuncio_id',
        'satisfacao',
        'satisfacao_text',
        'vendeu_qimob',
        'vendeu_qimob_valor',
        'vendeu_qimob_outro',
        'depoimento',
        'depoimento_text',
    ];

}
