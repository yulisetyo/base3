<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuratmasukController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
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
