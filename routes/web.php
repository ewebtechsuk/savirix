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
	return view('index');
});


/*Route::post('auth','Auth\AuthController@postLogin');
Route::post('forgot-password','Auth\PasswordController@postEmail');
Route::get('user/{token}','Auth\AuthController@getTokenInfo');
Route::post('reset','Auth\PasswordController@postReset');*/