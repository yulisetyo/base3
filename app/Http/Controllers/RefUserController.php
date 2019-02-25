<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class RefUserController extends Controller
{
    /**
	 * description 
	 */
	public function index()
	{
		$baseURL = \URL::to('/').'/home';
		
		if(session('username') == 'superadmin') {
			$data = [
				'side_menu' => MenuController::getMenu(),
				'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
			];
			
			return view('ref-user', $data);
		} else {
			return "<script>alert('Anda tidak memiliki akses ke halaman ini!');window.location.replace('".$baseURL."')</script>";
		}
	}

	/**
	 * data tabel untuk menanyangkan user
	 */
	public function tabel()
	{
		
	}
}
