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
        Schema::create('shop_order_shipping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->string('waybill_number',50)->nullable()->index();
            $table->string('label_url',512)->nullable();

            $table->float('weight',15,3);
            $table->float('length',15,3)->nullable();
            $table->float('width',15,3)->nullable();
            $table->float('height',15,3)->nullable();

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
        Schema::dropIfExists('shop_order_shipping');
    }
};
