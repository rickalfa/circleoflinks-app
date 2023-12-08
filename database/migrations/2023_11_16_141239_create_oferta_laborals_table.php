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
        Schema::create('oferta_laborals', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('name');

            $table->text('description')->nullable();
            $table->date('date_expire');
            $table->float('salary')->nullable();

         


            $table->timestamps();

            $table->unsignedBigInteger("status_oferta_laboral_id");

            $table->unsignedBigInteger("empresa_id");

      
            $table->foreign("status_oferta_laboral_id")->references("id")->on("status_oferta_laborals");

            $table->foreign("empresa_id")->references("id")->on("empresa");

         

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oferta_laborals');
    }
};
