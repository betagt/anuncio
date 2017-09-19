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

class CaracteristicaRoute implements ICustomRoute
{

    public static function run()
    {
        Route::group(['prefix'=>'admin','namespace'=>'Api\Admin'],function (){
            Route::get('caracteristica/lista', [
                'as' => 'user.api_finalidade_lista',
                'uses' => 'CaracteristicaController@getList',
            ]);
            Route::group(['middleware'=>['acl','auth:api'],'is'=>'administrador','protect_alias'=>'user'],function (){
                Route::resource('caracteristica', 'CaracteristicaController',
                    [
                        'except' => ['create', 'edit']
                    ]);
            });
        });
    }
}