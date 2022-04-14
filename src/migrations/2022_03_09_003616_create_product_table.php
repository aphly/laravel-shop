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
        Schema::create('shop_product', function (Blueprint $table) {
            $table->id();
            $table->string('sku',64)->default('')->index();
            $table->string('name',64);
            $table->integer('quantity')->unsigned();
            $table->string('image',255);
            $table->decimal('price');
            $table->tinyInteger('shipping')->default(1);
            $table->integer('points')->unsigned();
            $table->tinyInteger('stock_status_id');
            $table->float('weight');
            $table->tinyInteger('weight_class_id');
            $table->float('length');
            $table->float('width');
            $table->float('height');
            $table->tinyInteger('length_class_id');
            $table->tinyInteger('subtract')->default(1);
            $table->tinyInteger('minimum')->default(1);
            $table->tinyInteger('status')->default(1)->index();
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('sale')->unsigned()->default(0);
            $table->integer('sort')->unsigned();
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
        Schema::dropIfExists('shop_product');
    }
};
