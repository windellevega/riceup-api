<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shipping_address', 'address_lat', 'address_long', 'mobile_no'
    ];

    /**
    * Shipping Details that belong to User
    **/
    public function User()
    {
        return $this->belongsTo('App\User');
    }

    /**
    * Shipping Details that has Order
    **/
    public function Order()
    {
        return $this->has('App\Order');
    }
}
