<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->float('address_lat', 10, 6)
                    ->after('address');
            $table->float('address_long', 10, 6)
                    ->after('address_lat');
            $table->float('current_lat', 10, 6);
            $table->float('current_long', 10, 6);
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
            $table->dropColumn('address_lat');
            $table->dropColumn('address_long');
            $table->dropColumn('current_lat');
            $table->dropColumn('current_long');
        });
    }
}
