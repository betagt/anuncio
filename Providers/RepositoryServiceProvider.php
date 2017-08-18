<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 30/12/2016
 * Time: 10:44
 */

namespace Modules\Anuncio\Providers;

use Modules\Anuncio\Repositories\AnuncioAcessoRepository;
use Modules\Anuncio\Repositories\AnuncioAcessoRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioCaracteristicaRepository;
use Modules\Anuncio\Repositories\AnuncioCaracteristicaRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioCondicaoComercialRepository;
use Modules\Anuncio\Repositories\AnuncioCondicaoComercialRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioEmpreendimentoRepository;
use Modules\Anuncio\Repositories\AnuncioEmpreendimentoRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioExcluirFormRepository;
use Modules\Anuncio\Repositories\AnuncioExcluirFormRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioFrontRepository;
use Modules\Anuncio\Repositories\AnuncioFrontRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioImagemRepository;
use Modules\Anuncio\Repositories\AnuncioImagemRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioImovelRepository;
use Modules\Anuncio\Repositories\AnuncioImovelRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioPrecoRepository;
use Modules\Anuncio\Repositories\AnuncioPrecoRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioRepository;
use Modules\Anuncio\Repositories\AnuncioRepositoryEloquent;
use Modules\Anuncio\Repositories\AnuncioTelefoneRepository;
use Modules\Anuncio\Repositories\AnuncioTelefoneRepositoryEloquent;
use Modules\Anuncio\Repositories\CaracteristicaRepository;
use Modules\Anuncio\Repositories\CaracteristicaRepositoryEloquent;
use Modules\Anuncio\Repositories\FavoritoRepository;
use Modules\Anuncio\Repositories\FavoritoRepositoryEloquent;
use Modules\Anuncio\Repositories\FinalidadeCaracteristicaRepository;
use Modules\Anuncio\Repositories\FinalidadeCaracteristicaRepositoryEloquent;
use Modules\Anuncio\Repositories\FinalidadeRepository;
use Modules\Anuncio\Repositories\FinalidadeRepositoryEloquent;
use Modules\Anuncio\Repositories\MensagemAnuncioRepository;
use Modules\Anuncio\Repositories\MensagemAnuncioRepositoryEloquent;
use Modules\Anuncio\Repositories\ScoreRepository;
use Modules\Anuncio\Repositories\ScoreRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AnuncioRepository::class,
            AnuncioRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioFrontRepository::class,
            AnuncioFrontRepositoryEloquent::class
        );
        $this->app->bind(
            CaracteristicaRepository::class,
            CaracteristicaRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioImovelRepository::class,
            AnuncioImovelRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioEmpreendimentoRepository::class,
            AnuncioEmpreendimentoRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioAcessoRepository::class,
            AnuncioAcessoRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioPrecoRepository::class,
            AnuncioPrecoRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioCondicaoComercialRepository::class,
            AnuncioCondicaoComercialRepositoryEloquent::class
        );
        $this->app->bind(
            FavoritoRepository::class,
            FavoritoRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioImagemRepository::class,
            AnuncioImagemRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioCaracteristicaRepository::class,
            AnuncioCaracteristicaRepositoryEloquent::class
        );
        $this->app->bind(
            FinalidadeRepository::class,
            FinalidadeRepositoryEloquent::class
        );
        $this->app->bind(
            FinalidadeCaracteristicaRepository::class,
            FinalidadeCaracteristicaRepositoryEloquent::class
        );
        $this->app->bind(
            MensagemAnuncioRepository::class,
            MensagemAnuncioRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioTelefoneRepository::class,
            AnuncioTelefoneRepositoryEloquent::class
        );
        $this->app->bind(
            ScoreRepository::class,
            ScoreRepositoryEloquent::class
        );
        $this->app->bind(
            AnuncioExcluirFormRepository::class,
            AnuncioExcluirFormRepositoryEloquent::class
        );
    }
}