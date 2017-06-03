<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productorders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')
                    ->unsigned();
            $table->foreign('order_id')
                    ->references('id')
                    ->on('orders');
            $table->integer('fp_id')->unsigned();
            $table->foreign('fp_id')
                    ->references('id')
                    ->on('farmerproducts');
            $table->integer('quantity')
                    ->unsigned();
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
        //
    }
}
