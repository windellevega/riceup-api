<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'firstname', 'middlename', 
        'lastname', 'address', 'business_name', 'mobile_no',
        'years_in_business', 'photo_url', 'is_farmer', 'history',
        'years_in_farming',
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
    * Order that belongs to User
    **/
    public function Order()
    {
        return $this->hasMany('App\Order');
    }
}
