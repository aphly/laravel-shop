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
            $table->string('code',16)->index();
            $table->char('type',1);
            $table->tinyInteger('free_shipping')->nullable()->default(0);
            $table->decimal('discount',15,2);
            $table->decimal('total',15,2)->nullable();
            $table->unsignedInteger('date_start')->nullable();
            $table->unsignedInteger('date_end')->nullable();
            $table->integer('uses_total')->unsigned();
            $table->integer('uses_customer')->unsigned();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
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
