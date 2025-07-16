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

/*(Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/


Route::resource('property','PropertiesController', ['only'=>['index', 'show', 'store', 'update', 'destroy']]);
Route::resource('landlord','LandlordsController', ['only'=>['index', 'show', 'store', 'update', 'destroy']]);

Route::group(['middleware'=>'token'],function(){
	Route::post('import-property','PropertiesController@importProperties');
});
