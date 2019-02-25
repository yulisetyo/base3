<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model
{
	protected $connection = 'pbn_user';
	protected $table = 'users';
	public $primaryKey = 'id';
	protected $hidden = [
        'password', 'remember_token',
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
}
