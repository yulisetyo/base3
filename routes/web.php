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

	// login open
	//~ Route::get('/', 'LoginController@index');
	Route::get('/', 'HomeController@index');
	
	Route::get('/home', 'HomeController@index');

	//routing utnuk surat masuk
	Route::group(['prefix' => 'surat-masuk'], function(){
		
		Route::get('/', 'SuratmasukController@index');
		Route::get('/non', 'SuratmasukController@nonUndangan');
		Route::get('/und', 'SuratmasukController@undangan');
		Route::get('/agenda', 'SuratmasukController@agenda');
		Route::get('/follow', 'SuratmasukController@follow');
		Route::get('/pinned', 'SuratmasukController@pinned');
		Route::get('/plt', 'SuratmasukController@plt');
		Route::get('/rekam', 'SuratmasukController@rekam');
		
		Route::post('/', 'SuratmasukController@simpan');
		Route::post('/terima', 'SuratmasukController@doTerima');
		Route::post('/pinned', 'SuratmasukController@doPinned');
		Route::post('/unpinned', 'SuratmasukController@doUnpinned');
		
		Route::get('/disposisi/{param}', 'SuratmasukController@disposisioning');
		Route::get('/pilih/{param}', 'SuratmasukController@pilih');
		Route::get('/detail', 'SuratmasukController@tayangDetail');
		Route::get('/isi-detail/{param}', 'SuratmasukController@isiDetail');
		Route::get('/unreceived-tabel', 'SuratmasukController@suratMasukUnreceived');
		Route::get('/unpushed-tabel', 'SuratmasukController@suratMasukUnpushed');
		Route::get('/undisp-tabel', 'SuratmasukController@suratMasukUndisp');
		Route::get('/tabel', 'SuratmasukController@datatable');
		Route::get('/tabel2', 'SuratmasukController@datatable2');
		Route::get('/tabel-perekaman', 'SuratmasukController@dataTablePerekaman');
		Route::get('/pdf', 'SuratmasukController@tayangPDF');
		// ~ Route::get('/plt', 'SuratmasukController@dataTablePlt');
		Route::get('/tes', 'SuratmasukController@tes');
		
	});

	Route::group(['prefix' => 'tabel'], function(){
		Route::get('/plt', 'SuratmasukController@dataTablePlt');
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
		Route::get('/unit-kanpus', 'RefUnitController@dropdownUnitKantorPusat');
		Route::get('/jenis-surat', 'ReferensiController@opsiJenisSurat');
		Route::get('/undangan', 'SuratmasukController@suratUndangan');
		
	});
	
});

//route tes
Route::group(['prefix' => 'tes'], function(){
	Route::get('/', 'TesController@index');
	//~ Route::get('/foo', 'TesController@layoutView');
	Route::get('/foo', 'TesController@foo');
});	

