<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// login form
Route::get('/login', 'LoginController@index');

//get token
Route::get('/token', 'LoginController@token');

//login
Route::post('/postlogin', 'LoginController@authenticate');

//logout
Route::post('/logout', 'LoginController@logout');

//authenticated user
Route::group(['middleware' => 'auth'], function() {

	Route::get('/home', 'HomeController@index');

	//routing utnuk surat masuk
	Route::group(['prefix' => 'suratmasuk'], function(){
			
		Route::get('/', 'SuratmasukController@index');
		Route::post('/', 'SuratmasukController@simpan');
		Route::get('/pilih/{param}', 'SuratmasukController@pilih');
			
	});

	//routing untuk referensi
	Route::group(['prefix' => 'ref'], function(){

		//routing referensi user
		Route::group(['prefix' => 'user'], function(){
			Route::get('/', 'RefUserController@index');
		});

		//routing referensi sekretaris
		Route::group(['prefix' => 'sekre'], function(){
			Route::get('/', 'RefSekretarisController@index');
			Route::get('/cek', 'RefSekretarisController@cekSekretaris');
		});

		//routing referensi pejabat plt
		Route::group(['prefix' => 'plt'], function(){
			Route::get('/', 'RefPltController@index');
		});

		//routing referensi pegawai
		Route::group(['prefix' => 'pegawai'], function(){
			Route::get('/dropdown', 'PegawaiController@dropdownPegawai');
		});

		//routing referensi unit
		Route::group(['prefix' => 'unit'], function(){
			Route::get('/dropdown', 'RefUnitController@dropdownUnit');
			Route::get('/vertikal', 'RefUnitController@unitVertikal');
		});
		
	});

	//routing untuk dropdown
	Route::group(['prefix' => 'option'], function(){
		
	});
	
});

//route tes
Route::group(['prefix' => 'tes'], function(){
	Route::get('/', 'tesController@index');
});	

