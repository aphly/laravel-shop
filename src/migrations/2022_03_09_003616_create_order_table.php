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
        Schema::create('shop_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->index();
            $table->string('firstname',32);
            $table->string('lastname',32);
            $table->string('email',255);
            $table->string('telephone',255);
            $table->decimal('total');
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
        Schema::dropIfExists('shop_order');
    }
};
