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
        Schema::create('shop_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->tinyInteger('is_received')->nullable()->default(1);
            $table->tinyInteger('is_opened')->nullable()->default(0);
            $table->tinyInteger('service_action_id')->index();
            $table->tinyInteger('service_status_id')->nullable()->default(1);
            $table->text('reason')->nullable();
            $table->decimal('amount',15,2)->nullable();
            $table->string('amount_format',255)->nullable();
            $table->unsignedTinyInteger('refund_fee')->nullable()->default(0);
            $table->decimal('refund_amount',15,2)->nullable();
            $table->string('refund_amount_format',255)->nullable();
            $table->string('c_shipping',255)->nullable();
            $table->string('c_shipping_no',255)->nullable();
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->string('b_shipping_no',255)->nullable();
            $table->string('service_address',255)->nullable();
            $table->string('service_name',64)->nullable();
            $table->string('service_postcode',32)->nullable();
            $table->string('service_phone',32)->nullable();
            $table->unsignedBigInteger('delete_at')->nullable()->default(0);
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
        Schema::dropIfExists('shop_service');
    }
};
