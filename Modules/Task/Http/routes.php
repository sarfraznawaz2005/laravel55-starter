<?php

Route::group(['middleware' => 'XSSProtection'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Task\Http\Controllers'],
        function () {

            Route::group(['middleware' => 'auth'], function () {
                Route::resource('task', 'TaskController');
                Route::get('task/{task}/complete', 'TaskController@complete')->name('task.complete');
            });

        });
});
