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

Route::prefix('/v1')->namespace('API\v1')->as('api.v1.')->middleware('auth:api')->group(function () {
    Route::prefix('job')->as('job.')->group(function () {
        Route::get('/', 'JobController@index')->name('index');
        Route::put('/{job}', 'JobController@update')->name('update');
    });
});
