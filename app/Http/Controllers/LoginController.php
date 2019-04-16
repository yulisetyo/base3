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
		$data = [
			'appname' => 'adminLTE',
			'baseurl' => \URL::to('/').'/public',
		];
		return view("login", $data);
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
				$cekStatusLogin = Login::cekLogin($username, $password);

				// cek eksistensi user
				if(count($cekStatusLogin) != 0){

					// cek kecocockan password
					if(Hash::check($password, $cekStatusLogin[0]->password) == true){

						// cek status keaktifan user
						if($cekStatusLogin[0]->aktif == 'y') {

							// jik user eksis, password cocok, dan status user aktif maka buat session
							session([
								'authenticated' => true,
								'username' => $cekStatusLogin[0]->username,
								'name' => $cekStatusLogin[0]->name,
								'nip' => $cekStatusLogin[0]->nip,
								'kdunit' => $cekStatusLogin[0]->kdunit,
								'pkdunit' => strlen($cekStatusLogin[0]->kdunit),
								'eselon' => $cekStatusLogin[0]->eselon,
								'jeselon' => substr($cekStatusLogin[0]->eselon, 0, 1),
								'kdlevel' => $cekStatusLogin[0]->kdlevel,
								'jnskel' => $cekStatusLogin[0]->sex,
								'arraysession' => array(
									'username' => $cekStatusLogin[0]->username,
									'name' => $cekStatusLogin[0]->name,
									'nip' => $cekStatusLogin[0]->nip,
									'kdunit' => $cekStatusLogin[0]->kdunit,
									'pkdunit' => strlen($cekStatusLogin[0]->kdunit),
									'eselon' => $cekStatusLogin[0]->eselon,
									'jeselon' => substr($cekStatusLogin[0]->eselon, 0, 1),
									'kdlevel' => $cekStatusLogin[0]->kdlevel,
									'jnskel' => $cekStatusLogin[0]->sex,
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
			
			// ~ return response()->json(['error' => true, 'message' => $e->getMessage()]);
			return response()->json(['error' => true, 'code' => '500', 'message' => 'Internal Server Error']);
			
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
			
			//~ return '<script>window.location.href="./";</script>';
			return response()->json(['error' => false, 'message' => 'success']);
			
		} catch(\Exception $e) {
			
			return response()->json(['error' => true, 'message' => $e->getCode().' - '.$e->getMessage]);
		}
	}

}
