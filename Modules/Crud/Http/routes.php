<?php

Route::group([
    'middleware' => 'web',
    'prefix' => 'crud',
    'namespace' => 'Modules\Crud\Http\Controllers'
], function () {

    Route::group([
        'middleware' => [
            'auth.very_basic',
            'GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:50,30'
        ]
    ], function () {
        Route::get('/', 'CrudController@index')->name('crud.index');
    });

    Route::post('/store', 'CrudController@store')->name('crud.store');
    Route::get('/publish', 'CrudController@publish')->name('crud.publish');
    Route::get('/migrate', 'CrudController@migrate')->name('crud.migrate');
    Route::get('/toggle_status/{name}', 'CrudController@toggleStatus')->name('crud.toggle_status');
    Route::get('/optimize', 'CrudController@optimize')->name('crud.optimize');
    Route::post('/createfile', 'CrudController@createFile')->name('crud.createfile');
    Route::delete('/destroy/{name}', 'CrudController@destroy')->name('crud.destroy');
});
