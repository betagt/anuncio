<?php

/**
 * Created by PhpStorm.
 * User: dev06
 * Date: 09/08/2017
 * Time: 11:32
 */

namespace Modules\Anuncio\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AnuncioSiteScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('remove_site_view', '=', null);
    }

    public function remove(Builder $builder, Model $model){}
}