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
        'username', 'email', 'password', 'firstname', 'middlename', 
        'lastname', 'address', 'business_name', 'mobile_no',
        'years_in_business', 'photo_url', 'is_farmer', 'history',
        'years_in_farming', 'address_lat', 'address_long', 'current_lat',
        'current_long',
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

    public function findForPassport($username) {
       return self::where('username', $username)->first();
    }

    public function productsCount() {
        return $this->hasOne('App\FarmerProduct')
                ->selectRaw('user_id, count(*) as products')
                ->groupBy('user_id');
    }

    public function Order()
    {
        return $this->hasMany('App\Order');
    }

    /**
    * FarmerProduct that belongs to User
    **/
    public function FarmerProduct()
    {
        return $this->hasMany('App\FarmerProduct');
    }

    /**
    * Shipping Details that belong to User
    **/
    public function ShippingDetail()
    {
        return $this->hasMany('App\ShippingDetail');
    }
}
