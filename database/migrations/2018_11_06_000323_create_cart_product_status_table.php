<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartProductStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('po_id')
                ->unsigned();
            $table->foreign('po_id')
                ->references('id')
                ->on('product_orders');
            $table->unsignedTinyInteger('product_status');
            $table->text('details');
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
        Schema::dropIfExists('cart_product_status');
    }
}
