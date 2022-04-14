<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_banner_image', function (Blueprint $table) {
            $table->id();
            $table->integer('banner_id')->unsigned();
            $table->string('title',64);
            $table->string('link',255);
            $table->string('image',255);
            $table->integer('sort')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_banner_image');
    }
};
