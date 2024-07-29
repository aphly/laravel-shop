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
        Schema::create('shop_banner', function (Blueprint $table) {
            $table->id();
            $table->string('key',16)->index();
            $table->string('title',32)->nullable();
            $table->string('url',255)->nullable();
            $table->string('img',255);
            $table->string('img_m',255)->nullable();
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_banner');
    }
};
