<?php

Route::group(['middleware' => 'XSSProtection'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'],
        function () {

            #===========================================================#
            ### PUBLIC ROUTES START ###
            #===========================================================#

            Route::get('/', 'AdminController')->name('admin_login');
            Route::post('login', 'AdminController@login');

            ### PUBLIC ROUTES END ###
            #===========================================================#

            #===========================================================#
            ### AUTHENTICATED ROUTES START ###
            #===========================================================#
            Route::group(['middleware' => 'admin'], function () {
                Route::get('logout', 'AdminController@logout')->name('admin_logout');
                Route::get('panel', 'AdminController@index')->name('admin_panel');

                Route::get('user', 'UserController')->name('admin_user_listing');
            });
            #===========================================================#
            ### AUTHENTICATED ROUTES END ###
            #===========================================================#

        });
});
