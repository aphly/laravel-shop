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
            $table->unsignedInteger('coupon_id')->index();
            $table->integer('order_id')->unsigned();
            $table->unsignedBigInteger('uuid')->index();
            $table->decimal('amount');
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
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
