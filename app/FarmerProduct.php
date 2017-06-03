<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FarmerProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'product_name', 'product_desc',
        'price_per_unit', 'stocks_available',
        'date_of_harvest',
    ];

    /**
    * FarmerProduct that is in ProductOrder
    **/
    public function ProductOrder()
    {
        return $this->hasMany('App\ProductOrder');
    }
}
