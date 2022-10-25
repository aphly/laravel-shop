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
        Schema::create('shop_product_discount', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id')->index();
            $table->unsignedInteger('group_id')->index();
            $table->unsignedInteger('quantity')->nullable()->default(0);
            $table->decimal('price')->unsigned()->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_product_discount');
    }
};
