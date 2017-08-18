<?php
namespace Modules\Anuncio\Rotas;
use Portal\Interfaces\ICustomRoute;
use \Route;

class MensagemAnuncioRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
            Route::group(['middleware'=>['acl'],'is'=>'administrador','protect_alias'=>'user'],function (){
                Route::resource('mensagem_anuncio', 'MensagemAnuncioController',
                [
                    'except' => ['create', 'edit']
                ]);
            });
        });
        Route::group(['prefix'=>'front','middleware' => ['auth:api'],'namespace'=>'Api\Front'],function (){
            Route::post('mensagem_anuncio/registrar/{slug}', [
                'as' => 'user.mensagem_anuncio_registrar',
                'uses' => 'MensagemAnuncioController@registrar',
            ])->where('slug', '[A-Za-z0-9+]+');
            Route::group(['middleware'=>['acl'],'is'=>'administrador|anunciante|moderator|qative','protect_alias'=>'user'],function (){
                Route::resource('mensagem_anuncio', 'MensagemAnuncioController',
                [
                    'except' => ['create', 'edit']
                ]);
            });
        });
    }
}