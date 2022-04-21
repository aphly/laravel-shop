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
        Schema::create('shop_currency', function (Blueprint $table) {
            $table->id();
            $table->string('title',32);
            $table->string('code',3);
            $table->string('symbol_left',12);
            $table->string('symbol_right',12);
            $table->char('decimal_place',1);
            $table->decimal('value',15,8);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('shop_currency');
    }
};
