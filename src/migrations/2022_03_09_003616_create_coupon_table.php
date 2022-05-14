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
        Schema::create('shop_coupon', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('code',16);
            $table->char('type',1);
            $table->decimal('discount');
            $table->tinyInteger('is_login')->default(1)->nullable();
            $table->tinyInteger('shipping')->default(1);
            $table->decimal('total')->nullable()->default(0);
            $table->integer('date_start')->unsigned()->nullable();
            $table->integer('date_end')->unsigned()->nullable();
            $table->integer('uses_total')->unsigned();
            $table->integer('uses_user')->unsigned();
            $table->tinyInteger('status')->default(1);
            $table->integer('date_add')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_coupon');
    }
};
