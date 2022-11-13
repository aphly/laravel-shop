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
            $table->integer('order_id')->unsigned()->index();
            $table->integer('product_id')->unsigned();
            $table->string('name',128);
            $table->string('sku',64);
            $table->integer('quantity')->default(0)->nullable();
            $table->decimal('price',15,2);
            $table->decimal('total',15,2);
            $table->unsignedInteger('reward');
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
