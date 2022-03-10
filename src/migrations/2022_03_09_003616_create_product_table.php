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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->integer('cate_id')->unsigned()->index();
            $table->string('name',64)->index();
            $table->decimal('price',7,2);
            $table->decimal('old_price',7,2)->nullable();
            $table->integer('points')->unsigned()->nullable();
            $table->float('weight',7,3)->nullable();
            $table->integer('quantity')->default(0);
            $table->tinyInteger('status')->default(1)->index();
            $table->tinyInteger('is_stock')->default(0);
            $table->integer('viewed')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
