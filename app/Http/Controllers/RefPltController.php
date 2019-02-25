<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RefPltController extends Controller
{
	/**
	 * description 
	 */
	public function index()
	{
		$data = [
			'side_menu' => MenuController::getMenu(),
			'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
		];
			
		return view('page-blank', $data);
	}
}
