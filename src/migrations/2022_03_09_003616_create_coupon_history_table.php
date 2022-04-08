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
        Schema::create('coupon_history', function (Blueprint $table) {
            $table->id();
            $table->integer('coupon_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->char('uuid',32)->unsigned();
            $table->decimal('amount');
            $table->integer('data_add')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_history');
    }
};
