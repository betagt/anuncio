<?php

namespace Modules\Anuncio\Providers;

use Illuminate\Support\ServiceProvider;
use Portal\Models\Imagem;

class AnuncioServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Anuncio\Http\Controllers';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('count', function($attribute, $value, $parameters) {
            $count = app(Imagem::class)
                ->where('imagemtable_id',$value)
                ->where('imagemtable_type',$parameters[1])
                ->count();
            return !($count >= (int)$parameters[0]);
        });
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        \Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('Modules/Anuncio/Http/api.php');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('anuncio.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'anuncio'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/anuncio');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/anuncio';
        }, \Config::get('view.paths')), [$sourcePath]), 'anuncio');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/anuncio');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'anuncio');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'anuncio');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
