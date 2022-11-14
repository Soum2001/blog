<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_upload', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->String('img_path');
            $table->bigInteger('user_gallery_id');
            $table->bigInteger('flag');
            $table->foreign('user_gallery_id')->references('id')->on('user_galleries');
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
        Schema::dropIfExists('image_upload');
    }
}
