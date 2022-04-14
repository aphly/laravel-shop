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
        Schema::create('shop_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('uuid')->primary();
            $table->string('firstname',32)->nullable();
            $table->string('lastname',32)->nullable();
            $table->string('email',128)->nullable();
            $table->string('telephone',32)->nullable();
            $table->integer('address_id')->unsigned();
            $table->integer('role_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_customer');
    }
};
