<?php

Route::group(['middleware' => 'web', 'prefix' => 'main', 'namespace' => 'Modules\Main\Http\Controllers'], function()
{
    Route::get('/', 'MainController@index');
});
