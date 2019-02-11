<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
	 * description 
	 */
	public function index()
	{
		$data = [
			'side_menu' => MenuController::getMenu(),
		];
		
		return view('profile', $data);
	}
}
