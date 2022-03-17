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
            $table->string('spu',64)->default('')->index();
            $table->string('sku',64)->default('')->index();
            $table->string('name',64);
            $table->tinyInteger('status')->default(1)->index();
            $table->string('gender',64)->default('');
            $table->tinyInteger('size')->default(0);
            $table->tinyInteger('shape')->default(0);
            $table->string('material',64)->default('');
            $table->tinyInteger('frame')->default(0);
            $table->string('color',64)->default('');
            $table->string('feature',64)->default('');
            $table->decimal('price',7,2)->index();
            $table->integer('viewed')->unsigned()->default(0);
            $table->integer('createtime')->unsigned()->default(0)->index();

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
