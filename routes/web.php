<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['web'], 'prefix' => 'blog'], function() {
  Route::resource('/', 'BlogController');
  Route::post ( '/editItem', 'BlogController@editItem' );
  Route::post ( '/addItem', 'BlogController@addItem' );
  Route::post ( '/deleteItem', 'BlogController@deleteItem' );
});

Route::group(['middleware' => ['web'], 'prefix' => 'article'], function() {
  Route::resource('/', 'ArticleController');
  Route::post ( '/editItem', 'ArticleController@editItem' );
  Route::post ( '/addItem', 'ArticleController@addItem' );
  Route::post ( '/deleteItem', 'ArticleController@deleteItem' );
});
/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@dashboard')->name('admin:dashboard');

    Route::get('{model_name}/{action?}/{id?}', 'AdminController@getModelAction')
            ->name('admin:getModelAction')
            ->where('id', '[0-9]+');

    Route::post('{model_name}/{action?}/{id?}', 'AdminController@postModelAction')
            ->name('admin:postModelAction')
            ->where('id', '[0-9]+');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');