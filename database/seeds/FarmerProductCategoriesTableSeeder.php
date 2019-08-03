<?php

use Illuminate\Database\Seeder;

class FarmerProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $farmerproductcategories = [
	        [
				'category_name' => 'Fruits',
            ],
            [
				'category_name' => 'Vegetables',
            ],
            [
				'category_name' => 'Grains',
            ],
            [
				'category_name' => 'Herbs',
            ],
            [
				'category_name' => 'Bundles',
            ]
        ];

        DB::table('farmer_product_categories')->insert($farmerproductcategories);
    }
}
