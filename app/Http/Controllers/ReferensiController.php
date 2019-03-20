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

	/**
	 * description 
	 */
	public static function jenisSuratByTipe($jnssurat)
	{
		return DB::connection('pbn_ref')->select("
			SELECT CONCAT(t.mail_typeAbre, ' - ',t.mail_typeName) AS nmjenis
			FROM pbn_ref.ref_mail_type t
			WHERE t.mail_type = ?
		", [$jnssurat])[0]->nmjenis;
	}

	/**
	 * description 
	 */
	public static function formatTanggal($date) //dari format tanggal mysql yyyy-mm-dd
	{
		$fmtDate = date_format(date_create($date), 'Y-m-d');
		$arr_tanggal = explode("-", $fmtDate);
		$tahun = $arr_tanggal[0];
		$kdbulan = (int) $arr_tanggal[1];
		$tanggal = $arr_tanggal[2];

		$arr_bulan = [
			'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
			'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
		];

		return $tanggal." ".$arr_bulan[$kdbulan-1]." ".$tahun;
	}

	/**
	 * description 
	 */
	public static function formatWaktu($datetime)
	{
		$tw = date_format(date_create($datetime), 'Y-m-d');
		$tglindo = self::formatTanggal($tw);
		$wktindo = date_format(date_create($datetime), 'H:i:s');

		return $tglindo.' '.$wktindo;
	}
}
