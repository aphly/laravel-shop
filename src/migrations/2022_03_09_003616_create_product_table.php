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
            $table->unsignedBigInteger('uuid')->index();
            $table->string('sku',64)->nullable();
            $table->string('spu',64)->nullable()->index();
            $table->string('name',255)->nullable();
            $table->integer('quantity')->nullable();
            $table->string('image',255)->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->tinyInteger('shipping')->nullable()->default(1);
            $table->unsignedInteger('tax_class_id')->nullable()->default(1);
            $table->tinyInteger('stock_status_id');
            $table->float('weight')->nullable();
            $table->tinyInteger('weight_class_id');
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->tinyInteger('length_class_id');
            $table->tinyInteger('subtract')->nullable()->default(1);
            $table->tinyInteger('one_get_one')->nullable()->default(2);
            //$table->tinyInteger('minimum')->nullable()->default(1);
            $table->tinyInteger('status')->default(1)->index();
            $table->unsignedInteger('date_available')->nullable();
            $table->unsignedInteger('viewed')->nullable();
            $table->unsignedInteger('sale')->nullable();
            $table->unsignedInteger('sort')->nullable();
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
        Schema::dropIfExists('shop_product');
    }
};
