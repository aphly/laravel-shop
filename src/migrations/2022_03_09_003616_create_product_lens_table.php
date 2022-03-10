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
        Schema::create('product_lens', function (Blueprint $table) {
            $table->id();
            $table->integer('pid')->unsigned()->index();
            $table->string('name',64)->index();
            $table->decimal('price',7,2);
            $table->integer('points')->unsigned();
            $table->float('weight',7,3);
            $table->integer('quantity');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_stock')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_lens');
    }
};
