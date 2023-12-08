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
        Schema::create('user_oferta_laborals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('oferta_laboral_id')->nullable();
         
            $table->text('description')->nullable();

            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('oferta_laboral_id')->references('id')->on('oferta_laborals');
         
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
        Schema::dropIfExists('user_oferta_laborals');
    }
};
