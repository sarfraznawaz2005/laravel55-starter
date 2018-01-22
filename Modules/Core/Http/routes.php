<?php
Route::group(['middleware' => 'XSSProtection'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Core\Http\Controllers'],
        function () {
            Route::group(['middleware' => 'auth.very_basic'], function () {
                ### for logs ###
                Route::get('applogs__', '\Sarfraznawaz2005\Applog\ApplogController@index');
            });
        }
    );
});