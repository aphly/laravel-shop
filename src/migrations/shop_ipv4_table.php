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
        Schema::create('shop_ipv4', function (Blueprint $table) {
            $table->id();
            $table->char('country_iso',2);
            $table->char('ip_start',15);
            $table->char('ip_end',15);
            $table->unsignedBigInteger('ip_start_int');
            $table->unsignedBigInteger('ip_end_int');
            $table->index(['ip_start_int','ip_end_int']);
            //$table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_ipv4');
    }
};
