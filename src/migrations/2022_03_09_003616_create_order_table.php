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

            $table->unsignedBigInteger('address_id');
            $table->string('address_firstname',32);
            $table->string('address_lastname',32);
            $table->string('address_address_1',128);
            $table->string('address_address_2',128);
            $table->string('address_city',128);
            $table->string('address_postcode',10);
            $table->string('address_country',128);
            $table->unsignedInteger('address_country_id');
            $table->string('address_zone',128);
            $table->unsignedInteger('address_zone_id');
            $table->string('address_telephone',255);

            $table->unsignedBigInteger('shipping_id');
            $table->string('shipping_name',32);
            $table->string('shipping_desc',255);
            $table->decimal('shipping_cost');
            $table->decimal('shipping_free_cost');
            $table->unsignedBigInteger('shipping_geo_group_id');

            $table->unsignedBigInteger('payment_method_id');
            $table->string('payment_method_name',32);

            $table->decimal('total',15,4);
            $table->text('comment');

            $table->unsignedBigInteger('currency_id');
            $table->string('currency_code',8);
            $table->decimal('currency_value',15,8);

            $table->tinyInteger('order_status_id')->default(1)->index();

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
