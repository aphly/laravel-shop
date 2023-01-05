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
        Schema::create('shop_refund_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_return_id')->index();
            $table->unsignedBigInteger('order_return_status_id')->index();
            $table->tinyInteger('notify');
            $table->text('comment');
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
        Schema::dropIfExists('shop_refund_history');
    }
};
