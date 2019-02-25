<?php

namespace App\Http\Controllers;

use App\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;


class LoginController extends Controller
{

	/**
	 * description 
	 */
	public function index()
	{
		return view("login");
	}

	/**
	 * description 
	 */
	public function token()
	{
		return csrf_token();
	}
	
    /**
	 * Otentikasi user 
	 */
	public function authenticate(Request $request)
	{
		$username = $request->input('username');
		$password = $request->input('password');
		
		try {

			if($username == 'superadmin'){

				if( $password == 'p4ssw0rd!@)!(' ) {

					session([
						'authenticated' => true,
						'username' => 'superadmin',
						'name' => 'Administrator',
						'nip' => '060000060',
						'kdunit' => '1121101505',
						'pkdunit' => 10,
						'eselon' => '00',
						'jeselon' => '0',
						'kdlevel' => '00',
						'jnskel' => 'L',
						'arraysession' => array(
							'username' => 'superadmin',
							'name' => 'Administrator',
							'nip' => '060000060',
							'kdunit' => '1121101505',
							'pkdunit' => 10,
							'eselon' => '00',
							'jeselon' => '0',
							'kdlevel' => '00',
							'jnskel' => 'L',
						),
					]);

					return response()->json(['error' => false, 'message' => 'success']);

				} else {
					return response()->json(['error' => true, 'message' => $password]);
				}
				
			} else {
				$cekStatusLogin = Login::cekLogin($username, $password)[0];

				// cek eksistensi user
				if(count($cekStatusLogin) != 0){

					// cek kecocockan password
					if(Hash::check($password, $cekStatusLogin->password) == true){

						// cek status keaktifan user
						if($cekStatusLogin->aktif == 'y') {

							// jik user eksis, password cocok, dan status user aktif maka buat session
							session([
								'authenticated' => true,
								'username' => $cekStatusLogin->username,
								'name' => $cekStatusLogin->name,
								'nip' => $cekStatusLogin->nip,
								'kdunit' => $cekStatusLogin->kdunit,
								'pkdunit' => strlen($cekStatusLogin->kdunit),
								'eselon' => $cekStatusLogin->eselon,
								'jeselon' => substr($cekStatusLogin->eselon, 0, 1),
								'kdlevel' => $cekStatusLogin->kdlevel,
								'jnskel' => $cekStatusLogin->sex,
								'arraysession' => array(
									'username' => $cekStatusLogin->username,
									'name' => $cekStatusLogin->name,
									'nip' => $cekStatusLogin->nip,
									'kdunit' => $cekStatusLogin->kdunit,
									'pkdunit' => strlen($cekStatusLogin->kdunit),
									'eselon' => $cekStatusLogin->eselon,
									'jeselon' => substr($cekStatusLogin->eselon, 0, 1),
									'kdlevel' => $cekStatusLogin->kdlevel,
									'jnskel' => $cekStatusLogin->sex,
								),
							]);

							return response()->json(['error' => false, 'message' => 'success']);
							
						} else {
							return response()->json(['error' => true, 'message' => 'username tidak aktif!']);
						}
						
					} else {
						return response()->json(['error' => true, 'message' => 'password tidak sesuai!']);
					}
					
				} else {
					return response()->json(['error' => true, 'message' => 'username tidak ditemukan!']);
				}
			}
		} catch(\Exception $e) {
			
			return response()->json(['error' => true, 'message' => $e->getMessage()]);
			
		}
	}

	/**
	 * Reset password 
	 */
	public function reset(Request $request)
	{
		if(Session::get('username') == 'superadmin') {
			$username = $request->username;
			$password = Hash::make($request->password);

			$reset = \DB::table('users')
						->where('username', $username)
						->update(['password' => $password]);

			if($reset) {
				return response()->json(['error' => false, 'message'=>'success']);
			} else {
				return response()->json(['error' => true, 'message'=>'cannot reset password']);
			}
			
		} else {
			return response()->json(['error' => true, 'message'=>'restricted access']);
		}
	}

	/**
	 * description 
	 */
	public function resetAll()
	{
		if(Session::get('username') == 'superadmin') {
			$newPassword = Hash::make('p4ssw0rd!');

			$reset = \DB::table('users')
						->update(['password' => $newPassword]);

			if($reset) {
				return response()->json(['error' => false, 'message'=>'success']);
			} else {
				return response()->json(['error' => true, 'message'=>'cannot reset password']);
			}
			
		} else {
			return response()->json(['error' => true, 'message'=>'restricted access']);
		}		
	}

	/**
	 * Logout/keluar dari aplikasi 
	 */
	public function logout(Request $request)
	{
		try {
			session([
				'authenticated'	=> false,
				'username' 		=> null,
				'name' 			=> null,
				'nip' 			=> null,
				'kdunit' 		=> null,
				'eselon' 		=> null,
				'kdlevel' 		=> null,
				'arraysession' 	=> [
					'username' 		=> null,
					'name' 			=> null,
					'nip' 			=> null,
					'kdunit' 		=> null,
					'eselon' 		=> null,
					'kdlevel' 		=> null,
				]
			]);
			
			$request->session()->forget('key');
			$request->session()->flush();
			Session::flush();
			
			return '<script>window.location.href="./";</script>';
			
		} catch(\Exception $e) {
			return response()->json(['error' => true, 'message' => $e->getCode().' - '.$e->getMessage]);
		}
	}

}
