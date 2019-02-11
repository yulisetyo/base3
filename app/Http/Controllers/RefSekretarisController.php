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
			
			return view('ref-sekretaris', $data);
		} else {
			return "<script>alert('Anda tidak memiliki akses ke halaman ini!');</script>";
		}
	}

	/**
	 * description 
	 */
	public static function cekSekretaris($nip)
	{
		try {			
			$rows = DB::connection('pbn_mail')->table('dt_emp_under')
												->where('nip', $nip)
												->where('active', 'y')
												->first();
			
			return $rows;
			
		} catch(\Exception $e){
			return $e->getMessage();
		}
	}
	
}
