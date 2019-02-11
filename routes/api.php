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

Route::get('/login', 'ApiController@index');

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function() {

	Route::post('/register', 'ApiController@register');
	Route::post('/apilogin', 'ApiController@authenticate');
	Route::get('/open', 'DataController@open');

	Route::group(['middleware' => ['jwt.verify']], function() {
		Route::get('/user', 'ApiController@getAuthenticatedUser');
		Route::get('/closed', 'DataController@closed');	
	});
	
});


