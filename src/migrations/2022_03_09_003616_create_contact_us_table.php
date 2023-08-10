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
        Schema::create('shop_contact_us', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->index()->nullable();
            $table->string('email',128)->index();
            $table->tinyInteger('is_view')->default(0);
            $table->tinyInteger('is_reply')->default(0);
            $table->text('content')->nullable();
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
        Schema::dropIfExists('shop_contact_us');
    }
};
