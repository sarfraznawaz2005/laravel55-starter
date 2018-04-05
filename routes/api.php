<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//////////////////////////////////////////////////////////////
// for API/Vue Task Component (Sample)
//////////////////////////////////////////////////////////////
Route::get('tasks', 'API\TaskAPIController@index');
Route::post('tasks', 'API\TaskAPIController@store');
Route::delete('tasks/{id}', 'API\TaskAPIController@destroy');
Route::get('tasks/{id}', 'API\TaskAPIController@view');
Route::put('tasks/{id}', 'API\TaskAPIController@update');
//////////////////////////////////////////////////////////////
