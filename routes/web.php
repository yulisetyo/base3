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

// login open
Route::get('/', 'LoginController@index');

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
	Route::group(['prefix' => 'surat-masuk'], function(){
		
		Route::get('/', 'SuratmasukController@index');
		Route::post('/', 'SuratmasukController@simpan');
		Route::post('/terima', 'SuratmasukController@terima');
		Route::post('/pinned', 'SuratmasukController@pinned');
		Route::post('/unpinned', 'SuratmasukController@unpinned');
		Route::get('/disposisi/{param}', 'SuratmasukController@disposisioning');
		Route::get('/pilih/{param}', 'SuratmasukController@pilih');
		Route::get('/detail/{param}', 'SuratmasukController@detail');
		Route::get('/isi-detail/{param}', 'SuratmasukController@isiDetail');
		Route::get('/unreceived-tabel', 'SuratmasukController@suratMasukUnreceived');
		Route::get('/unpushed-tabel', 'SuratmasukController@suratMasukUnpushed');
		Route::get('/undisp-tabel', 'SuratmasukController@suratMasukUndisp');
		Route::get('/tes-tabel', 'SuratmasukController@dataTable');
		Route::get('/pdf/{param}', 'SuratmasukController@tayangPDF');
		Route::get('/tes', 'SuratmasukController@tes');
		
	});

	//routing untuk referensi
	Route::group(['prefix' => 'ref'], function(){

		//routing referensi user
		Route::group(['prefix' => 'user'], function(){

			Route::get('/', 'RefUserController@index');
			Route::post('/reset', 'LoginController@reset');

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

			Route::get('/', 'RefUnitController@index');
			Route::get('/vertikal', 'RefUnitController@unitVertikal');

		});
		
	});

	//routing untuk dropdown
	Route::group(['prefix' => 'opsi'], function(){

		Route::get('/unit-lengkap', 'RefUnitController@dropdownUnitLengkap');
		Route::get('/jenis-surat', 'ReferensiController@opsiJenisSurat');
		
	});
	
});

//route tes
Route::group(['prefix' => 'tes'], function(){
	Route::get('/', 'TesController@index');
	Route::get('/foo', 'TesController@foo');
});	

