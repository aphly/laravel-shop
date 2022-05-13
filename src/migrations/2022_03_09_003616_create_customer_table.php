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
            $table->unsignedInteger('address_id')->nullable()->default(0);
            $table->unsignedInteger('customer_group')->index();
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
