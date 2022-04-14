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
        Schema::create('shop_coupon_history', function (Blueprint $table) {
            $table->id();
            $table->integer('coupon_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->unsignedBigInteger('uuid');
            $table->decimal('amount');
            $table->integer('date_add')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_coupon_history');
    }
};
