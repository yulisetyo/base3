<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class ReferensiController extends Controller
{
	/**
	 * description 
	 */
	public static function jenisSurat()
	{
		$rows = \DB::connection('pbn_ref')->select("
			SELECT t.mail_type AS kode, t.mail_typeAbre As nama, t.mail_typeName AS uraian, t.`status`
			FROM pbn_ref.ref_mail_type t
			ORDER BY 1
		");

		foreach($rows as $row) {
			$arrData[] = array(
				'kode' => $row->kode,
				'nama' => $row->nama,
				'uraian' => $row->uraian,
			);
		}

		return $arrData;
	}

	/**
	 * description 
	 */
	public function opsiJenisSurat()
	{
		$arrData = self::jenisSurat();
		$html = '<option value="" style="display:none;">Pilih</option>';

		if(count($arrData) > 0) {
			foreach($arrData as $data) {
				$html .= '<option value="'.$data['kode'].'">'.$data['nama'].' - '.$data['uraian'].'</option>';
			}
		}
		 
		return $html;
	}
}
