<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class RefSekretarisController extends Controller
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
			
			return view('ref_sekretaris', $data);
		} else {
			return "<script>alert('Anda tidak memiliki akses ke halaman ini!');</script>";
		}
	}
}
