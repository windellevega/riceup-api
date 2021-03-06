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
        'user_id', 'order_date', 'delivery_date', 'sd_id',
        'mode_of_shipping', 'order_status', 'order_number',
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
    public function User()
    {
        return $this->belongsTo('App\User');
    }

    /**
    * User that has ShippingDetail
    **/
    public function ShippingDetail()
    {
        return $this->belongsTo('App\ShippingDetail', 'sd_id');
    }

    /**
    * Mutator for Order Number prepend RUORD
    **/
    public function setOrderNumberAttribute($value)
    {
        $this->attributes['order_number'] = strtoupper('RUORD' . $value);
    }
}
