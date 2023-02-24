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
        Schema::create('shop_option', function (Blueprint $table) {
            $table->id();
            $table->string('type',64);
            $table->string('name',64);
            $table->integer('sort')->unsigned();
            $table->unsignedBigInteger('filter_group_id')->index();
            $table->tinyInteger('status')->default(1)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_option');
    }
};
