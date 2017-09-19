<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/02/2017
 * Time: 15:29
 */

namespace Modules\Anuncio\Rotas;
use Portal\Interfaces\ICustomRoute;
use \Route;

class FinalidadeRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','middleware' => ['auth:api'],'namespace'=>'Api\Admin'],function (){
           Route::group(['middleware'=>['acl'],'is'=>'administrador','protect_alias'=>'user'],function (){
               Route::get('finalidade/lista', [
                   'as' => 'user.api_finalidade_lista',
                   'uses' => 'FinalidadeController@getList',
               ]);
                Route::resource('finalidade', 'FinalidadeController',
                    [
                        'except' => ['create', 'edit']
                ]);
            });
        });
        Route::group(['prefix'=>'front','namespace'=>'Api\Front'],function (){
            Route::get('finalidade/lista', [
                'as' => 'user.api_finalidade_lista',
                'uses' => 'FinalidadeController@getList',
            ]);
            Route::group(['middleware'=>['acl','auth:api'],'is'=>'administrador','protect_alias'=>'user'],function (){
                Route::get('finalidade/select-finalidade', [
                    'as' => 'plano.consulta_bairros',
                    'uses' => 'FinalidadeController@selectFinalidades'
                ]);
            });
        });
    }
}