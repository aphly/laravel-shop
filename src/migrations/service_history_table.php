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
        Schema::create('shop_service_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->index();
            $table->unsignedBigInteger('service_action_id')->index();
            $table->unsignedBigInteger('service_status_id')->index();
            $table->tinyInteger('notify');
            $table->text('comment');
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
        Schema::dropIfExists('shop_service_history');
    }
};
