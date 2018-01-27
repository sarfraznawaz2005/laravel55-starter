<?php

Route::group(['middleware' => 'web', 'prefix' => 'task', 'namespace' => 'Modules\Task\Http\Controllers'], function()
{
    Route::get('/', 'TaskController@index')->name('task.index');
});
