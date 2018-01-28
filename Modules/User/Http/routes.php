<?php
Route::group(['middleware' => 'XSSProtection'], function () {

    Route::group(['middleware' => 'web', 'prefix' => 'user', 'namespace' => 'Modules\User\Http\Controllers'],
        function () {
            #===========================================================#
            ### PUBLIC ROUTES START ###
            #===========================================================#

            Auth::routes();

            // verify registration
            if (config('user.account_email_verification')) {
                Route::get('register/verify/{confirmationCode}', [
                    'as' => 'user.verify',
                    'uses' => 'Auth\RegisterController@confirm'
                ]);
            }

            ### PUBLIC ROUTES END ###
            #===========================================================#
        });
});


