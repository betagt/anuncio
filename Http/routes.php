<?php

Route::group(['middleware' => 'web', 'prefix' => 'anuncio', 'namespace' => 'Modules\Anuncio\Http\Controllers'], function()
{
    Route::get('/', 'AnuncioController@index');
});
