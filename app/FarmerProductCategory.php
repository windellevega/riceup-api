<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FarmerProductCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_name'];

    //Category has many Farmer Products
    public function FarmerProducts()
    {
        return $this->hasMany('App\FarmerProduct');
    }
}
