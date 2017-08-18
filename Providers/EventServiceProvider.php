<?php

namespace Modules\Anuncio\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Anuncio\Events\AnuncioCadastrado;
use Modules\Anuncio\Events\GerarScore;
use Modules\Anuncio\Listeners\LogAnuncioPreco;
use Modules\Anuncio\Listeners\MarcarPonto;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AnuncioCadastrado::class => [
            LogAnuncioPreco::class
        ],
        GerarScore::class => [
            MarcarPonto::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
