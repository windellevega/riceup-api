<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password', 60);
            $table->string('firstname');
            $table->string('middlename')
                    ->nullable();
            $table->string('lastname');
            $table->string('address');
            $table->string('business_name');
            $table->string('mobile_no')
                    ->nullable();
            $table->string('email')
                    ->unique()
                    ->nullable();
            $table->unsignedTinyInteger('years_in_business');
            $table->string('photo_url');
            $table->boolean('is_farmer');
            $table->text('history')
                    ->nullable();
            $table->unsignedTinyInteger('years_in_farming')
                    ->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
