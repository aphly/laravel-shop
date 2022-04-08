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
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('image',255);
            $table->integer('pid')->unsigned()->index();
            $table->integer('sort')->unsigned();
            $table->tinyInteger('status');
            $table->text('description');
            $table->string('meta_title',255);
            $table->string('meta_keyword',255);
            $table->string('meta_description',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
};
