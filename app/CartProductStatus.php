<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartProductStatus extends Model
{
    protected $table = 'cart_product_status';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'po_id', 'product_status', 'details',
    ];

    /**
    * ProductOrder has many status
    **/
    public function ProductOrder()
    {
        return $this->belongsTo('App\ProductOrder');
    }
}
