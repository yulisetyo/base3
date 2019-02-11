<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PustakaController extends Controller
{
    /**
	 * description 
	 */
	public static function getUserIP()
	{
		$client		= @$_SERVER['HTTP_CLIENT_IP'];
		$forward	= @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote		= $_SERVER['REMOTE_ADDR'];
		
		if(filter_var($client, FILTER_VALIDATE_IP)) {
			$ip = $client;
		} elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
			$ip = $forward;
		} else {
			$ip = $remote;
		}
		
		return $ip;
	}
	
	/**
	 * description 
	 */
	public static function setUserIP()
	{
			if( self::getUserIP() == '::1' ) {
				$ip = '127001';
			} else {
				$xip = self::getUserIP();
				$arr = explode(".", $xip);
				$ip = (int) implode("", $arr);
			}
			
			return $ip;
	}
	
	/**
	 * description 
	 */
	public static function fmtTanggal($date)
	{
		$arrBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		$tahun = substr($data, 0, 4);
		$bulan = substr($data, 5, 2);
		$tgl = substr($data, 8, 2);
		
		$tanggal = $tgl." ".$arrBulan[(int)$bulan-1]." ".$tahun;
		return $tanggal;
	}
}
