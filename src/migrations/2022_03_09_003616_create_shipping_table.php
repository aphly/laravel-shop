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
        Schema::create('shop_shipping', function (Blueprint $table) {
            $table->id();
            $table->string('name',32);
            $table->string('desc',255);
            $table->decimal('cost')->nullable();
            $table->decimal('free')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->integer('sort')->nullable()->default(1)->index();
            $table->unsignedInteger('geo_group_id')->nullable()->default(0)->index();
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
        Schema::dropIfExists('shop_shipping');
    }
};
