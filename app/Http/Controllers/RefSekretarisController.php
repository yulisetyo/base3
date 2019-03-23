<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

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
				'nm_unit' => RefUnitController::unitById(session('kdunit'))->nm_unit,
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
			
			return [
				'nip' => $rows->nip,
				'kdunit' =>$rows->unit,
				'atasan' =>$rows->upNip,
				'jabatan' =>$rows->upJab,
			];
			
		} catch(\Exception $e){
			return [];
		}
	}
	
}
