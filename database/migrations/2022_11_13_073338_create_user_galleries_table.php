<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_galleries', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('user_id');
            $table->bigInteger('gallery_type_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('gallery_type_id')->references('id')->on('gallery_type');
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
        Schema::dropIfExists('user_galleries');
    }
}
