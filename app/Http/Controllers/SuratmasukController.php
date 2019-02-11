<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Controllers\MenuController;

class SuratmasukController extends Controller
{
    /**
	 * description 
	 */
	public function index()
	{
			$data = [
				'side_menu' => MenuController::getMenu(),
				'nm_unit' => 'DJPB',
			];
			
			return view('surat-masuk', $data);
	}

	/**
	 * description 
	 */
	public function tabel()
	{
		
	}

	/**
	 * description 
	 */
	public function simpan()
	{
		
	}

	/**
	 * description 
	 */
	public function pilih($param)
	{
		
	}
}
