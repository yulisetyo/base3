<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TesController extends Controller
{
    public function index()
	{
		//~ $user = User::where('id',1)->first();
		$user = User::where('id', '>', 2)->firstOrFail();
		return response()->json($user);
	}

	public function hashing()
	{
		//~ $word = 'password';
		//~ $ncr = Hash::make($word);
		//~ return $ncr;

		$passthru = Hash::make('secret');
		$user = User::find(3);
		$user->password  = $passthru;
		$update = $user->save();
		if($update) {
			return response()->json(User::find(3));
		} 
	}

	/**
	 * description 
	 */
	public function authenticate(Request $request)
	{
		$credentials = $request->only('username', 'password');

		try {
			if( ! $token = JWTAuth::attempt($credentials) ) {
				return response()->json(['error' => 'invalid_credentials'], 400);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'could_not_create_token'], 500);
		}

		return response()->json(compact('token'));
	}

	/**
	 * description 
	 */
	public function register(Request $request)
	{
		$validator = Validator::make( $request->all(), [
			'name' => 'required|string|max:255',
			'nip' => 'required|string|min:9|max:18',
			'username' => 'required|string|max:18|unique:users',
			'password' => 'required|string|min:6|confirmed',
			'kdunit' => 'required|string|min:6|max:20',
			'eselon' => 'required|string|min:2|max:2',
			'kdlevel' => 'required|string|min:2|max:2',
		]);

		if($validator->fails()) {
			return response()->json($validator->errors()->toJson(), 400);
		}

		$user = User::create([
			'name' => $request->input('name'),
			'nip' => $request->input('nip'),
			'username' => $request->input('username'),
			//~ 'password' => Hash::make($request->input('password')),
			'password' => sha1(md5($request->input('password'))),
			'kdunit' => $request->input('kdunit'),
			'eselon' => $request->input('eselon'),
			'kdlevel' => $request->input('kdlevel'),
		]);

		$token = JWTAuth::fromUser($user);

		return response()->json(compact('user','token'),201);
	}

	/**
	 * description 
	 */
	public function getAuthenticatedUser()
	{
		try {
			if( ! $user = JWTAuth::parseToken()->authenticate() ) {
				return response()->json(['user_not_found'], 404);
			} 
		} catch(Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['token_expired'], $e->getStatusCode());
		} catch(Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json(['token_invalid'], $e->getStatusCode());
		} catch(Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json(['token_absent'], $e->getStatusCode());
		}

		return response()->json(compact('user'));
	}
}
