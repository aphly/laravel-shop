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
        Schema::create('shop_product_option_value', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_option_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('option_id')->index();
            $table->unsignedBigInteger('option_value_id')->index();
            $table->unsignedBigInteger('product_image_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->tinyInteger('subtract')->unsigned()->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->integer('sort')->default(0)->nullable();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_product_option_value');
    }
};
