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
		if(session('username') == 'superadmin') {
			$data = [
				'side_menu' => MenuController::getMenu(),
				'nm_unit' => 'DJPB',
			];
			
			return view('ref-user', $data);
		} else {
			return "<script>alert('Anda tidak memiliki akses ke halaman ini!');</script>";
		}
	}

	/**
	 * data tabel untuk menanyangkan user
	 */
	public function tabel()
	{
		
	}
}
