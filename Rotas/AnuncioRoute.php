<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:29
 */

namespace Modules\Anuncio\Rotas;
use Portal\Http\Middleware\CacheMiddleware;
use Portal\Interfaces\ICustomRoute;
use \Route;

class AnuncioRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::get('anuncio/suspender/{id}', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@suspender',
            ]);
            Route::get('anuncio/imagens/{id}', [
                'as' => 'user.api_anuncio_imagens',
                'uses' => 'AnuncioController@imagensByAnuncios',
            ]);

            Route::get('anuncio/metricas', [
                'as' => 'user.api_anuncio_imagens',
                'uses' => 'AnuncioController@statisticas',
            ]);

            Route::post('anuncio/imagem/reordenar', [
                'as' => 'user.api_anuncio_imagem_reordenar',
                'uses' => 'AnuncioController@reOrdenar',
            ]);
            Route::post('anuncio/imagem/{id}', [
                'as' => 'user.api_anuncio_imagem',
                'uses' => 'AnuncioController@salvarImagem',
            ]);

            Route::delete('anuncio/imagem/destroy-image/{id}', [
                'as' => 'user.api_anuncio_imagem_reordenar',
                'uses' => 'AnuncioController@destroyImage',
            ]);

            Route::group(['middleware'=>['acl'],'is'=>'administrador','protect_alias'=>'user'],function (){
                Route::resource('anuncio', 'AnuncioController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
            //,'middleware' => ['auth:api']
        Route::group(['prefix'=>'front','namespace'=>'Api\Front'],function (){
            Route::get('anuncio/lista-anuncios', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@listSite',
            ]);//->middleware(CacheMiddleware::class);
			Route::get('anuncio/ofertas-capa', [
				'as' => 'user.api_anuncio_suspender',
				'uses' => 'AnuncioController@ofertasCapa',
			])->middleware(CacheMiddleware::class);
            Route::get('anuncio/visualizar/{slug}', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@vizualizar',
            ])->where('slug', '[A-Za-z0-9+]+');

            Route::get('anuncio/score-telefone/{id}', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@scoreTelefone',
            ]);
            Route::get('anuncio/score-imprimir/{id}', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@scoreImpressao',
            ]);
            Route::get('anuncio/score-favoritar/{id}', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@scoreFavoritar',
            ]);
            Route::get('anuncio/score-permanencia/{id}', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@scorePermanencia',
            ]);
            Route::get('anuncio/score-alerta/{id}', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@scoreAlerta',
            ]);
            Route::get('anuncio/score-compartilhar/{id}', [
                'as' => 'user.api_anuncio_suspender',
                'uses' => 'AnuncioController@scoreCompartilhar',
            ]);
            Route::group(['middleware'=>['acl','auth:api'],'is'=>'administrador|anunciante|moderator|qative','protect_alias'=>'user'],function (){
                Route::post('anuncio/imagem/reordenar', [
                    'as' => 'user.api_anuncio_imagem_reordenar',
                    'uses' => 'AnuncioController@reOrdenar',
                ]);
                Route::get('anuncio/imagens/{id}', [
                    'as' => 'user.api_anuncio_imagens',
                    'uses' => 'AnuncioController@imagensByAnuncios',
                ]);
                Route::post('anuncio/imagem/{id}', [
                    'as' => 'user.api_anuncio_imagem',
                    'uses' => 'AnuncioController@salvarImagem',
                ]);
                Route::post('anuncio/imagem64/{id}', [
                    'as' => 'user.api_anuncio_imagem',
                    'uses' => 'AnuncioController@salvarImagem64',
                ]);

                Route::delete('anuncio/imagem/destroy-image/{id}', [
                    'as' => 'user.api_anuncio_imagem_reordenar',
                    'uses' => 'AnuncioController@destroyImage',
                ]);

                Route::post('anuncio/remover-and-pesquisa/{slug}', [
                    'as' => 'user.api_anuncio_imagem_reordenar',
                    'uses' => 'AnuncioController@removerByPesquisa',
                ])->where('slug', '[A-Za-z0-9+]+');

                Route::get('anuncio/remover-and-pesquisa/{slug}', [
                    'as' => 'user.api_anuncio_imagem_reordenar',
                    'uses' => 'AnuncioController@removerByPesquisa',
                ])->where('slug', '[A-Za-z0-9+]+');

                Route::resource('anuncio', 'AnuncioController',
                    [
                        'except' => ['create','destroy', 'excluir', 'trasheds', 'edit']
                    ]);
            });
        });
    }
}