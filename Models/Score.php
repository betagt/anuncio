<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Score extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'user_id',
        'acesso',
        'ponto',
        'anuncio_id',
    ];

    const LABEL_VIEW = 'view';
    const LABEL_FONE_CLICK = 'fone_click';
    const LABEL_COMPARTILHAR = 'compartilhar';
    const LABEL_IMPRIMIR = 'imprimir';
    const LABEL_PERMANENCIA = 'permanencia';

    const LABEL_FAVORITO = 'favorito';
    const LABEL_ALERT = 'alert';

    public static $labels = [
        self::LABEL_VIEW=>1,
        self::LABEL_FONE_CLICK=>2,
        self::LABEL_PERMANENCIA=>3,
        self::LABEL_FAVORITO=>3,
        self::LABEL_ALERT=>3,
        self::LABEL_COMPARTILHAR=>3,
        self::LABEL_IMPRIMIR=>2
    ];

    public static function _getKeysLabel(){
        return array_keys(self::$labels);
    }

    public static function _getValue($label){
        return self::$labels[$label];
    }
}
