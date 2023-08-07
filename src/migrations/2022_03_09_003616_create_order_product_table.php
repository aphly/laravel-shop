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
        Schema::create('shop_order_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('name',255);
            $table->string('image',255);
            $table->string('sku',64);
            $table->unsignedInteger('quantity')->nullable();
            $table->decimal('price',15,2);
            $table->string('price_format',255);
            $table->decimal('total',15,2);
            $table->string('total_format',255);
            $table->decimal('discount',15,2);
            $table->string('discount_format',255);
            $table->decimal('real_total',15,2);
            $table->string('real_total_format',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_order_product');
    }
};
