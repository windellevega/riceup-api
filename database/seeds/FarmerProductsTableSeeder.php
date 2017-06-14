<?php

use Illuminate\Database\Seeder;

class FarmerProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$farmerproducts = [
	        [
	        	'user_id' => 2,
	        	'product_name' => 'Ang Tabako',
	        	'photo_url' => '/photos/product/default.jpg',
	        	'product_desc' => 'Tobacco that is good for making you slim af.',
	        	'unit_type' => 'bundle',
	        	'price_per_unit' => 500.50,
	        	'stocks_available' => 500,
	        	'date_of_harvest' => '2017-05-20'
	        ],
	        [
	        	'user_id' => 2,
	        	'product_name' => 'Jackie Rice',
	        	'photo_url' => '/photos/product/default.jpg',
	        	'product_desc' => 'Ang bigas na makinis pa sa GF mo',
	        	'unit_type' => 'sack',
	        	'price_per_unit' => 3000,
	        	'stocks_available' => 20,
	        	'date_of_harvest' => '2017-06-01'
	        ],
	        [
	        	'user_id' => 2,
	        	'product_name' => 'White Corn',
	        	'photo_url' => '/photos/product/default.jpg',
	        	'product_desc' => 'They say it\'s white, I say it\'s fresh',
	        	'unit_type' => 'sack',
	        	'price_per_unit' => 4200.25,
	        	'stocks_available' => 10,
	        	'date_of_harvest' => '2017-06-01'
	        ],
	        [
	        	'user_id' => 3,
	        	'product_name' => 'Rice and Shine',
	        	'photo_url' => '/photos/product/default.jpg',
	        	'product_desc' => 'Shiny af.',
	        	'unit_type' => 'sack',
	        	'price_per_unit' => 3500.12,
	        	'stocks_available' => 15,
	        	'date_of_harvest' => '2017-06-01'
	        ],
	        [
	        	'user_id' => 3,
	        	'product_name' => 'Rice Rice Baby',
	        	'photo_url' => '/photos/product/default.jpg',
	        	'product_desc' => 'Rice that is good for your babies',
	        	'unit_type' => 'sack',
	        	'price_per_unit' => 5100.25,
	        	'stocks_available' => 10,
	        	'date_of_harvest' => '2017-06-01'
	        ],
	        [
	        	'user_id' => 3,
	        	'product_name' => 'Mais White',
	        	'photo_url' => '/photos/product/default.jpg',
	        	'product_desc' => 'Mine is whiter than others.',
	        	'unit_type' => 'sack',
	        	'price_per_unit' => 4300.25,
	        	'stocks_available' => 10,
	        	'date_of_harvest' => '2017-06-01'
	        ]
	    ];
        DB::table('farmer_products')->insert($farmerproducts);
    }
}
