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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('phone_number')->nullable();
            $table->timestamp('last_message_time')->nullable();
            $table->string('state')->nullable();

            $table->unsignedBigInteger('user_id')->unique();

            $table->foreign('user_id')->references('id')->on('user_app');

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
        Schema::dropIfExists('leads');
    }
};
