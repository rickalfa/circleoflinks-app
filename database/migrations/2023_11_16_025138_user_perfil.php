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
        //

        Schema::create("user_perfil", function (Blueprint $table) {

            $table->id();
            $table->text("info");
            $table->string("education", 255);
            $table->text("exp_laboral");
            $table->text("habilidades");
            $table->string("profetion_name",255);

            $table->unsignedBigInteger("user_id")->unique();

            $table->foreign("user_id")->references("id")->on("user_app");


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
        //

        Schema::dropIfExists("user_perfil");


    }
};
