<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFpCategoryIdToFarmerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('farmer_products', function (Blueprint $table) {
            $table->integer('fp_category_id')
                ->unsigned()
                ->after('product_name')
                ->nullable();
            $table->foreign('fp_category_id')
                ->references('id')
                ->on('farmer_product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('farmer_products', function (Blueprint $table) {
            //
        });
    }
}
