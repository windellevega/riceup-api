<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllowNullOnAddressAndCurrentLatLongUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address_lat')
            ->nullable()
            ->change();
            $table->string('address_long')
            ->nullable()
            ->change();
            $table->string('current_lat')
            ->nullable()
            ->change();
            $table->string('current_long')
            ->nullable()
            ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address_lat')
            ->change();
            $table->string('address_long')
            ->change();
            $table->string('current_lat')
            ->change();
            $table->string('current_long')
            ->change();
        });
    }
}
