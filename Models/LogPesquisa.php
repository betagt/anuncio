<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class LogPesquisa extends Model implements Transformable
{

    use TransformableTrait;

    protected $fillable = [
    	'pesquisa'
	];

	public function setPesquisaAttribute($value)
	{
		if ($value)
			$this->attributes['pesquisa'] = base64_encode($value);
	}

	public function getPesquisaAttribute()
	{

		return json_decode(base64_decode($this->attributes['pesquisa']));
	}

}
