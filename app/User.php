<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nip', 'username', 'password', 'kdunit', 'eselon', 'kdlevel', 'aktif'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
	 * get JWT identifier 
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * get JWT Custom Claims 
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}
}
/* THIS MODEL USED TO API AUTHENTICATION */