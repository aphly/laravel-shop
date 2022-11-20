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
            $table->string('sku',64)->nullable()->default('');
            $table->string('model',64)->nullable()->default('')->index();
            $table->string('name',64)->nullable();
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
            $table->tinyInteger('subtract')->default(1);
            $table->tinyInteger('minimum')->nullable()->default(1);
            $table->tinyInteger('status')->default(1)->index();
            $table->unsignedInteger('date_available')->nullable()->default(0);
            $table->unsignedInteger('viewed')->nullable()->default(0);
            $table->unsignedInteger('sale')->nullable()->default(0);
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
