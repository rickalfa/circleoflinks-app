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
        Schema::create('status_ofeta_laborals', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);

            $table->text('description');

            $table->unsignedBigInteger('oferta_laboral_id')->unique();


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
        Schema::dropIfExists('status_ofeta_laborals');
    }
};
