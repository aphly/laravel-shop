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
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('uid')->index();
            $table->string('email',255)->nullable();
            $table->unsignedBigInteger('payment_id')->nullable()->index();

            $table->unsignedBigInteger('address_id');
            $table->string('delivery_firstname',32);
            $table->string('delivery_lastname',32);
            $table->string('delivery_address_1',128);
            $table->string('delivery_address_2',128)->nullable();
            $table->string('delivery_city',128);
            $table->string('delivery_postcode',10);
            $table->string('delivery_country',128);
            $table->unsignedBigInteger('delivery_country_id');
            $table->string('delivery_zone',128);
            $table->unsignedBigInteger('delivery_zone_id');
            $table->string('delivery_telephone',255);

            $table->unsignedTinyInteger('same')->default(1);

            $table->string('billing_firstname',32);
            $table->string('billing_lastname',32);
            $table->string('billing_address_1',128);
            $table->string('billing_address_2',128)->nullable();
            $table->string('billing_city',128);
            $table->string('billing_postcode',10);
            $table->string('billing_country',128);
            $table->unsignedBigInteger('billing_country_id');
            $table->string('billing_zone',128);
            $table->unsignedBigInteger('billing_zone_id');

            $table->unsignedBigInteger('shipping_id');
            $table->string('shipping_name',32);
            $table->string('shipping_desc',255)->nullable();
            $table->decimal('shipping_cost',15,2);
            $table->decimal('shipping_free_cost',15,2)->nullable();
            $table->unsignedBigInteger('shipping_geo_group_id')->nullable();
            $table->string('express_name',255)->nullable();
            $table->string('express_no',255)->nullable();

            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->string('payment_method_name',32)->nullable();
            $table->unsignedBigInteger('items');
            $table->decimal('total',15,2);
            $table->string('currency_code',8);
            $table->string('total_format',255);
            $table->text('comment')->nullable();

            $table->unsignedBigInteger('order_status_id')->default(1)->index();

            $table->string('ip',64)->nullable();
            $table->string('user_agent',255)->nullable();
            $table->string('accept_language',255)->nullable();
            $table->unsignedBigInteger('delete_at')->default(0);
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
            $table->engine = 'InnoDB';
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
