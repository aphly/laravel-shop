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
        Schema::create('shop_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid');
            $table->string('firstname',32);
            $table->string('lastname',32);
            $table->string('address',255);
            $table->string('city',128);
            $table->string('postcode',10);
            $table->string('telephone',32);
            $table->integer('country_id');
            $table->integer('zone_id');
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
        Schema::dropIfExists('shop_address');
    }
};
