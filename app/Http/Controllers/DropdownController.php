<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropdownController extends Controller
{
	/**
	 * description 
	 */
	public static function option(Array $arrData)
	{
		$html = '<option value="" style="">Pilih</option>';

		if(count($arrData) > 0) {
			foreach($arrData as $data) {
				$html .= '<option value="'.$data['kode'].'">'.$data['kode'].'|'.$data['uraian'].'</option>';
			}
		}
		 
		return $html;
	}
	
	/**
	 * description 
	 */
	public static function option2(Array $arrData)
	{
		$html = '<option value="" style="display:none;">Pilih</option>';

		if(count($arrData) > 0) {
			foreach($arrData as $data) {
				$html .= '<option value="'.$data['kode'].'">'.$data['uraian'].'</option>';
			}
		}
		 
		return $html;
	}

}
