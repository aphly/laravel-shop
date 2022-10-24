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
        Schema::create('shop_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->index();
            $table->string('email',255);
            $table->string('telephone',255);
            $table->string('shipping_firstname',32);
            $table->string('shipping_lastname',32);
            $table->string('shipping_address_1',128);
            $table->string('shipping_address_2',128);
            $table->string('shipping_city',128);
            $table->string('shipping_postcode',10);
            $table->string('shipping_country',128);
            $table->unsignedInteger('shipping_country_id');
            $table->string('shipping_zone',128);
            $table->unsignedInteger('shipping_zone_id');
            $table->string('shipping_method',128);
            $table->string('shipping_code',128);
            $table->string('payment_method',128);
            $table->string('payment_code',128);
            $table->text('comment');
            $table->decimal('total',15,4);
            $table->tinyInteger('order_status_id')->default(1)->index();
            $table->unsignedInteger('currency_id');
            $table->string('currency_code',3);
            $table->decimal('currency_value',15,8);
            $table->string('ip',64);
            $table->string('user_agent',255);
            $table->string('accept_language',255);
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
        Schema::dropIfExists('shop_order');
    }
};
