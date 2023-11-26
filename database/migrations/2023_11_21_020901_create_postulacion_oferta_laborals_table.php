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
        Schema::create('postulacion_oferta_laborals', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->text('description');
            $table->date('date_expire');




            
            $table->unsignedBigInteger('oferta_laboral_id');


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
        Schema::dropIfExists('postulacion_oferta_laborals');
    }
};
