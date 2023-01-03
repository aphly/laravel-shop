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
        Schema::create('shop_order_return', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('uuid')->index();
            $table->string('firstname',32);
            $table->string('lastname',32);
            $table->string('email',128);
            $table->string('telephone',32);
            $table->string('product',255);
            $table->unsignedBigInteger('quantity');
            $table->tinyInteger('opened');
            $table->text('comment');
            $table->unsignedBigInteger('order_return_reason_id');
            $table->unsignedBigInteger('order_return_action_id');
            $table->unsignedBigInteger('order_return_status_id');
            $table->unsignedBigInteger('delete_at');
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
        Schema::dropIfExists('shop_order_return');
    }
};
