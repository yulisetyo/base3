<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
		
        return view('beranda', $data);
	}

}
