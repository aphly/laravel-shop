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
        Schema::create('shop_review', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->unsigned()->index();
            $table->unsignedBigInteger('uuid')->index();
            $table->string('author',64);
            $table->text('text');
            $table->tinyInteger('rating');
            $table->tinyInteger('status')->index();
            $table->integer('date_add')->unsigned();
            $table->integer('date_edit')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_review');
    }
};
