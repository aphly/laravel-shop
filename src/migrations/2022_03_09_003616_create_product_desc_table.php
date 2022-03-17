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
        Schema::create('product_desc', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->primary();
            $table->text('description');
            $table->decimal('old_price',7,2)->nullable();
            $table->integer('points')->unsigned()->nullable()->default(0);
            $table->float('weight',7,3)->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->tinyInteger('is_stock')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_desc');
    }
};
