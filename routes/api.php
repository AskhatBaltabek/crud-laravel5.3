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

Route::get('/get/{model_name}/{id?}', 'ApiController@getModel')->name('api:getModel');

Route::get('/get/{model_name}/with/{with_models}/{id?}', 'ApiController@getModelWithRelation')->name('api:getModelWithRelation');

