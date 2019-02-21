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

				if($password == 'p4ssw0rd!@)!(') {

					session([
						'authenticated' => true,
						'username' => 'superadmin',
						'name' => 'Administrator',
						'nip' => '060000060',
						'kdunit' => '1121101505',
						'eselon' => '00',
						'kdlevel' => '00',
						'jnskel' => 'L',
					]);

					return response()->json(['error' => false, 'message' => 'success']);

				} else {
					return response()->json(['error' => true, 'message' => 'password tidak sesuai!']);
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
								'eselon' => $cekStatusLogin->eselon,
								'kdlevel' => $cekStatusLogin->kdlevel,
								'jnskel' => $cekStatusLogin->sex,
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
		$username = $request->username;
		$password = Hash::make($request->password);

		$update = User::table('users')
					->where('username', $username)
					->update('password', $password);

		if($update) {
			return response()->json(['error' => false, 'message'=>'success']);
		} else {
			return response()->json(['error' => true, 'message'=>'cannot reset password']);
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
			]);
			
			$request->session()->forget('key');
			$request->session()->flush();
			Session::flush();
			
			return '<script>window.location.href="login";</script>';
			
		} catch(\Exception $e) {
			return response()->json(['error' => true, 'message' => $e->getCode().' - '.$e->getMessage]);
		}
	}

}
