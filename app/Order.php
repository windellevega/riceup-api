<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'order_date', 'delivery_date',
        'mode_of_shipping', 'order_status',
    ];

    /**
    * ProductOrder that belong to Order
    **/
    public function ProductOrder()
    {
        return $this->hasMany('App\ProductOrder');
    }

    /**
    * User that has Order
    **/
    public function ProductOrder()
    {
        return $this->belongsTo('App\User');
    }
}
