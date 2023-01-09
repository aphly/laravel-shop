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
        Schema::create('shop_return_exchange', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->tinyInteger('is_received')->nullable()->default(1);
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->unsignedBigInteger('quantity')->nullable();
            $table->tinyInteger('is_opened')->nullable()->default(2);
            $table->tinyInteger('return_exchange_action_id')->index();
            $table->tinyInteger('return_exchange_status_id');
            $table->text('reason');
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
        Schema::dropIfExists('shop_return_exchange');
    }
};
