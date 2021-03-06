<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'fp_id', 'farmerproducts', 'quantity',
    ];

    /**
    * Order where ProductOrder belongs to
    **/
    public function Order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
    * FarmerProduct that are on ProductOrder
    **/
    public function FarmerProduct()
    {
        return $this->belongsTo('App\FarmerProduct', 'fp_id')->withTrashed();
    }

    /**
     * ProductOrder has many CartProductStatus
     */
    public function CartProductStatus()
    {
        return $this->hasMany('App\CartProductStatus', 'po_id');
    }

    public function currentStatus()
    {
        return $this->hasOne('App\CartProductStatus', 'po_id')->latest();
    }
}