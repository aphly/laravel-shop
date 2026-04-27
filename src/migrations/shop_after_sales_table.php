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
        Schema::create('shop_after_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uid')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->tinyInteger('is_received')->default(1);
            $table->tinyInteger('is_opened')->default(0);
            $table->text('content')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('delete_at')->default(0);
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_after_sales');
    }
};
