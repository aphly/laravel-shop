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
        Schema::create('shop_customer_wishlist', function (Blueprint $table) {
            $table->unsignedBigInteger('uuid')->index();
            $table->integer('product_id')->unsigned();
            $table->integer('date_add')->unsigned();
            $table->primary(['uuid','product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_customer_wishlist');
    }
};
