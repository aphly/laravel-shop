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
        Schema::create('shop_cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('uuid')->index();
            $table->integer('product_id')->unsigned()->index();
            $table->char('visitor',32)->index();
            $table->unsignedInteger('quantity')->default(1);
            $table->json('json')->nullable();
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
        Schema::dropIfExists('shop_cart');
    }
};
