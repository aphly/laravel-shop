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
        Schema::create('shop_category_path', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('path_id')->unsigned();
            $table->integer('level')->unsigned();
            $table->primary(['category_id','path_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_category_path');
    }
};
