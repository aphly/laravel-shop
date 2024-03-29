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
            $table->string('name',64);
            $table->string('cn_name',64)->nullable();
            $table->string('desc',255)->nullable();
            $table->decimal('cost',15,2)->nullable();
            $table->decimal('free_cost',15,2)->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->integer('sort')->nullable()->default(1);
            $table->tinyInteger('default')->nullable()->default(0);
            $table->unsignedInteger('geo_group_id')->nullable()->index();
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
