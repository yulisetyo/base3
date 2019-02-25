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
		$jeselon = session('jeselon');

		if($jeselon == '1') {
			$data['pageview'] = '';
		} else if($jeselon == '2') {
			$data['pageview'] = '';
		} else if($jeselon == '3') {
			$data['pageview'] = '';
		} else if($jeselon == '4') {
			$data['pageview'] = '';
		} else {
			$data['pageview'] = '';
		}
		
		$data = [
			'side_menu' => MenuController::getMenu(),
			'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
		];
		
        return view('beranda', $data);
	}

}
