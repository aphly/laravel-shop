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
        Schema::create('shop_order_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->index();
            $table->unsignedInteger('order_status_id');
            $table->tinyInteger('notify')->default(0)->nullable();
            $table->text('comment');
            $table->unsignedInteger('date_add');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_order_history');
    }
};
