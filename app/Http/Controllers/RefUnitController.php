<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class RefUnitController extends Controller
{
	/**
	 * description 
	 */
	public function index()
	{
		$baseURL = \URL::to('/').'/home';

		$data = [
			'side_menu' => MenuController::getMenu(),
			'nm_unit' => self::unitById(session('kdunit'))->nm_unit,
		];
		
		return view('page-blank', $data);
	}
	
    /**
	 * description 
	 */
	public static function unitAll()
	{
		if(isset($_GET['jes'])) {
			if($_GET['jes'] == '1') {
				$where['jes'] = " AND LENGTH(n.idUnit) <= 10 ";
			}
			else if($_GET['jes'] == '2') {
				$where['jes'] = " AND LENGTH(n.idUnit) <= 13 ";
			}
			else if($_GET['jes'] == '3') {
				$where['jes'] = " AND LENGTH(n.idUnit) <= 15 ";
			} else {
				$where['jes'] = " AND LENGTH(n.idUnit) <= 17 ";
			}
		} else {
			$where['jes'] = " AND LENGTH(n.idUnit) <= 17 ";
		}

		$rows = DB::select("
			SELECT n.jbtnId AS id_jab, n.idUnit AS kd_unit, j.jbtnNama AS nm_unit, LENGTH(n.idUnit) AS pkr
			FROM pbn_ref.ref_unit n
			INNER JOIN (
				SELECT j.jbtnId, j.jbtnNama
				FROM pbn_ref.ref_jabatan j
			) j ON n.jbtnId = j.jbtnId
			WHERE n.idUnit IS NOT NULL
				  ".$where['jes']."
				  AND RIGHT(n.idUnit, 3) != '000'
		");

		$data = [];
		
		if(count($rows) > 0) {
			foreach($rows as $row) {
				$data[] = [
					'kode' => $row->kd_unit,
					'uraian' => $row->nm_unit,
				];
			}
		} 

		return $data;
	}

	/**
	 * description 
	 */
	public static function unitById($kd_unit)
	{
		$unit = DB::select("
			SELECT t.*
			FROM(
				SELECT n.jbtnId AS id_jab, n.idUnit AS kd_unit, j.jbtnNama AS nm_unit, LENGTH(n.idUnit) AS pkr
				FROM pbn_ref.ref_unit n
				INNER JOIN (
				SELECT j.jbtnId, j.jbtnNama
				FROM pbn_ref.ref_jabatan j) j ON n.jbtnId = j.jbtnId
				WHERE LENGTH(n.idUnit) <= 17 AND
				      RIGHT(n.idUnit, 3) != '000'
			) t
			WHERE t.kd_unit = ?
		", [$kd_unit]);

		return $unit[0];
	}

	/**
	 * description 
	 */
	public function unitVertikal()
	{
		$kdunit  = session('kdunit');
		
		if(strlen($kdunit) == 10) {
			$where['length'] = " AND LENGTH(n.idUnit) <= 13 ";
		} else if(strlen($kdunit) == 13) {
			$where['length'] = " AND LENGTH(n.idUnit) <= 15 ";
		} else if(strlen($kdunit) == 15) {
			$where['length'] = " AND LENGTH(n.idUnit) <= 17 ";
		} 

		$rows = DB::select("
			SELECT t.*
			FROM(
				SELECT n.jbtnId AS id_jab, n.idUnit AS kd_unit, j.jbtnNama AS nm_unit, LENGTH(n.idUnit) AS pkr
				FROM pbn_ref.ref_unit n
				INNER JOIN (
				SELECT j.jbtnId, j.jbtnNama
				FROM pbn_ref.ref_jabatan j) j ON n.jbtnId = j.jbtnId
				WHERE RIGHT(n.idUnit, 3) != '000'
				      ".$where['length']."
			) t
			WHERE SUBSTR(t.kd_unit,1,10) LIKE '".$kdunit."%';
		");

		$data = [];

		if(count($rows) > 0) {
			foreach($rows as $row) {
				$data[] = [
					'kode' => $row->kd_unit,
					'uraian' => $row->nm_unit,
				];
			}
		}

		return DropdownController::option($data);
	}

	/**
	 * description 
	 */
	public function dropdownUnit()
	{
		$arrData = self::unitAll();
		return DropdownController::option($arrData);
	}

	/**
	 * description 
	 */
	public static function unitLengkap()
	{
		$rows = DB::connection('pbn_ref')
				->select("
					SELECT t.idunit, t.eselon, t.tipe, t.jbtnnama AS idunit, t.jkantor, t.uvertikal
					FROM (SELECT LEFT(u.idunit, 10) AS idunit, LEFT(j.eselon, 2) AS eselon, j.tipe, j.jbtnnama, 'PS' AS jkantor, LEFT(u.idunit, 10) AS uvertikal
						FROM pbn_ref.ref_unit u
						INNER JOIN pbn_ref.ref_jabatan j ON j.jbtnId = u.jbtnId
						WHERE LENGTH(u.idunit) = 10
						#
						UNION
						#
						SELECT LEFT(u.idunit, 13) AS idunit, LEFT(j.eselon, 2) AS eselon, j.tipe, j.jbtnnama, 'PS' AS jkantor, LEFT(u.idunit, 10) AS uvertikal
						FROM pbn_ref.ref_unit u
						INNER JOIN pbn_ref.ref_jabatan j ON j.jbtnId = u.jbtnId
						WHERE j.tipe = 'P' AND LENGTH(u.idunit) = 13 AND RIGHT(u.idunit, 3) != '000'
						#
						UNION
						#
						SELECT
						LEFT(u.idunit, 15) AS idunit, LEFT(j.eselon, 2) AS eselon, j.tipe, j.jbtnnama, 'KW' AS jkantor,
						LEFT(u.idunit, 10) AS uvertikal
						FROM pbn_ref.ref_unit u
						INNER JOIN pbn_ref.ref_jabatan j ON j.jbtnId = u.jbtnId
						WHERE LEFT(j.tipe, 1) = 'K' AND LEFT(j.eselon,1) != '9' AND LENGTH(u.idunit) = 13
						#
						UNION
						#
						SELECT '1121101505134' AS idunit, 21 AS eselon, 'K2' AS tipe, 'Kantor Wilayah Direktorat Jenderal Perbendaharaan Provinsi Kalimantan Utara' AS jbtnnama, 'KW' AS jkantor, '1121101505' AS uvertikal
						#
						UNION
						#
						SELECT LEFT(u.idunit, 15) AS idunit, LEFT(j.eselon, 2) AS eselon, j.tipe, j.jbtnnama, 'KP' AS jkantor, LEFT(u.idunit, 13) AS uvertikal
						FROM pbn_ref.ref_unit u
						INNER JOIN pbn_ref.ref_jabatan j ON j.jbtnId = u.jbtnId
						WHERE LEFT(j.tipe, 1) = 'A' AND LENGTH(u.idunit) = 15
						#
						UNION
						#
						SELECT LEFT(u.idunit, 15) AS idunit, LEFT(j.eselon, 2) AS eselon, j.tipe, j.jbtnnama, 'KH' AS jkantor, LEFT(u.idunit, 13) AS uvertikal
						FROM pbn_ref.ref_unit u
						INNER JOIN pbn_ref.ref_jabatan j ON j.jbtnId = u.jbtnId
						WHERE UPPER(j.tipe) = 'KH' AND LENGTH(u.idunit) = 15
					) t
					ORDER BY 1
				");
		return $rows;
	}
}
