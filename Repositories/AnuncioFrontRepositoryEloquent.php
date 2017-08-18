<?php

namespace Modules\Anuncio\Repositories;

use Modules\Anuncio\Models\Anuncio;

/**
 * Class AnuncioRepositoryEloquent
 * @package namespace Modules\Anuncio\Repositories;
 */
class AnuncioFrontRepositoryEloquent extends AnuncioRepositoryEloquent implements AnuncioFrontRepository
{

    public function boot()
    {
        static::scopeQuery(function ($query){
            return $query->where('remove_site_view', '=', null);
        });
        parent::boot();
    }

}
