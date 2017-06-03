<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmerproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmerproducts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                    ->unsigned();
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
            $table->string('product_name');
            $table->string('product_desc');
            $table->decimal('price_per_unit', 6, 3);
            $table->integer('stocks_available')
                    ->unsigned();
            $table->date('date_of_harvest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farmerproducts');
    }
}
