<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class RefPegawaiController extends Controller
{
	/**
	 * description 
	 */
	public function pegawai()
	{
		if(isset($_GET['jes'])) {
			if($_GET['jes'] == '1') {
				$where['jes'] = " AND SUBSTR(e.eselon, 1, 1) = '1' "; 
			} else if($_GET['jes'] == '2') {
				$where['jes'] = " AND SUBSTR(e.eselon, 1, 1) = '2' ";
			} else if($_GET['jes'] == '3') {
				$where['jes'] = " AND SUBSTR(e.eselon, 1, 1) = '3' ";
			} else if($_GET['jes'] == '4') {
				$where['jes'] = " AND SUBSTR(e.eselon, 1, 1) = '4' ";
			} else {
				$where['jes'] = " AND SUBSTR(e.eselon, 1, 1) >= '7' ";
			}
		} else {
			$where['jes'] = " ";
		}

		$rows = DB::select("
			SELECT e.nip, e.nama, e.eselon, e.gol, e.unit, e.sex
			FROM pbn_emp.dt_emp e
			WHERE e.active = 'y'
				  ".$where['jes']."
			ORDER BY eselon ASC, nip ASC
		");

		$data = [];
		
		if(count($rows) > 0) {
			foreach($rows as $row) {
				$data[] = [
					'kode' => $row->nip,
					'uraian' => $row->nama,
				];
			}
		}

		return $data;
	}

	/**
	 * description 
	 */
	public function dropdownPegawai()
	{
		$html = '<option value="" style="">Pilih</option>';

		if(count(self::unitAll()) > 0) {
			foreach(self::unitAll() as $row) {
				$html .= '<option value="'.$row->kd_unit.'">'.$row->kd_unit.'|'.$row->nm_unit.'</option>';
			}
		}
		 
		return $html;
	}
}
