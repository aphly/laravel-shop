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
        Schema::create('shop_customer_reward', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid');
            $table->integer('order_id')->unsigned();
            $table->text('description')->nullable();
            $table->integer('points')->unsigned();
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
        Schema::dropIfExists('shop_customer_reward');
    }
};
