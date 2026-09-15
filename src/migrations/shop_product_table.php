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
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('uid')->index();
            $table->string('sku',64)->nullable();
            $table->string('spu',64)->nullable()->index();
            $table->string('name',255)->nullable();
            $table->text('url')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('image',255)->nullable();
            $table->string('disk',16)->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->tinyInteger('is_shipping')->default(1);
            $table->unsignedInteger('tax_class_id')->default(1);
            $table->tinyInteger('stock_status_id');
            $table->float('weight')->nullable();
            $table->tinyInteger('weight_class_id');
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->tinyInteger('length_class_id');
            $table->tinyInteger('subtract')->default(1);
            $table->tinyInteger('one_get_one')->default(0);
            $table->tinyInteger('is_color_group')->default(0);
            //$table->tinyInteger('minimum')->nullable()->default(1);
            $table->tinyInteger('status')->default(1)->index();
            $table->unsignedInteger('date_available')->nullable();
            $table->unsignedInteger('viewed')->nullable();
            $table->unsignedInteger('sale')->nullable();
            $table->unsignedInteger('sort')->nullable();

            $table->float('declaration_unit_weight',8,3)->nullable();
            $table->string('declaration_name_local',50)->nullable();
            $table->string('declaration_name_en',50)->nullable();
            $table->string('declaration_hs_code',50)->nullable();
            $table->string('declaration_material',50)->nullable();
            $table->string('declaration_brand',50)->nullable();
            $table->string('declaration_remark',50)->nullable();

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
