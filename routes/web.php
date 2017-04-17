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

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');