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
            $table->integer('product_option_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->integer('option_id')->unsigned()->index();
            $table->integer('option_value_id')->unsigned()->index();
            $table->integer('product_image_id')->unsigned()->nullable();
            $table->integer('quantity')->nullable();
            $table->tinyInteger('subtract')->unsigned()->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->float('weight')->nullable();
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
