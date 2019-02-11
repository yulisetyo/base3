<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model
{
	protected $table = 'users';
	protected $hidden = [
        'remember_token',
    ];

    /**
	 * description 
	 */
	public static function cekLogin($username, $password)
	{
		$rows = DB::select("
			SELECT u.*, e.sex
			FROM pbn_user.users u
			LEFT JOIN pbn_emp.dt_emp e ON e.nip = u.nip
			WHERE u.username = ?
		", [$username]);

		return $rows;
	}
    
	/**
	 * description 
	 */
	//~ public static function cekUsername($username)
	//~ {
		//~ $rows = DB::select("
			//~ SELECT u.uId id, u.uName username, u.uPass AS password, u.uNip nip, u.uRealName nama, u.idUnit kdunit, IFNULL(e.unit,'1121101505001') unit, IFNULL(e.eselon, 99) eselon, u.uActive AS aktif, NOW() AS created_at, NULL AS updated_at
			//~ FROM pbn_user.user_data u
			//~ LEFT JOIN pbn_emp.dt_emp e ON u.uNip = e.nip
			//~ WHERE u.uName = '?'
		//~ ", [$username]);

		//~ if(count($rows) > 0) {
			//~ return count($rows);
		//~ } else {
			//~ return 0;
		//~ }
	//~ }

	/**
	 * description 
	 */
	//~ public static function cekPassword($username, $password)
	//~ {
		//~ $rows = DB::select("
			//~ SELECT u.uId id, u.uName username, u.uPass AS password, u.uNip nip, u.uRealName nama, u.idUnit kdunit, IFNULL(e.unit,'1121101505001') unit, IFNULL(e.eselon, 99) eselon, u.uActive AS aktif, NOW() AS created_at, NULL AS updated_at
			//~ FROM pbn_user.user_data u
			//~ LEFT JOIN pbn_emp.dt_emp e ON u.uNip = e.nip
			//~ WHERE u.uName = ? AND u.uPass = ?
		//~ ", [$username, $password]);

		//~ if(count($rows) > 0) {
			//~ return count($rows);
		//~ } else {
			//~ return 0;
		//~ }
	//~ }

	/**
	 * description 
	 */
	//~ public static function cekAktif($username, $password)
	//~ {
		//~ $rows = DB::select("
			//~ SELECT u.uId id, u.uName username, u.uPass AS password, u.uNip nip, u.uRealName nama, u.idUnit kdunit, IFNULL(e.unit,'1121101505001') unit, IFNULL(e.eselon, 99) eselon, u.uActive AS aktif, NOW() AS created_at, NULL AS updated_at
			//~ FROM pbn_user.user_data u
			//~ LEFT JOIN pbn_emp.dt_emp e ON u.uNip = e.nip
			//~ WHERE u.uName = ? AND u.uPass = ? AND u.uActive = 'y'
		//~ ", [$username, $password, 'y']);

		//~ if(count($rows) > 0) {
			//~ return count($rows);
		//~ } else {
			//~ return 0;
		//~ }		
	//~ }
	
	/**
	 * description 
	 */
	//~ public static function userData($username, $password)
	//~ {
		//~ $rows = DB::select("
			//~ SELECT u.uId id, u.uName username, u.uPass AS password, u.uNip nip, u.uRealName nama, u.idUnit kdunit, IFNULL(e.unit,'1121101505001') unit, IFNULL(e.eselon, 99) eselon, u.uActive AS aktif, NOW() AS created_at, NULL AS updated_at
			//~ FROM pbn_user.user_data u
			//~ LEFT JOIN pbn_emp.dt_emp e ON u.uNip = e.nip
			//~ WHERE u.uName = ? AND u.uPass = ? AND u.uActive = 'y'
		//~ ", [$username, $password, 'y']);

		//~ return $rows[0];
	//~ }
}
