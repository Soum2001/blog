<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->String('username');
            $table->String('email');
            $table->String('address');
            $table->String('phone_no');
            $table->String('password');
            $table->bigInteger('user_type');
            $table->foreign('user_type')->references('id')->on('user_types')->onDelete('cascade');
            $table->String('active');
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
        Schema::dropIfExists('user_details');
    }
}
