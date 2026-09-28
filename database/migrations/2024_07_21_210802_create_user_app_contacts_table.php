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
        /**
         * relacion con la entidad user_app
         */
        Schema::create('user_app_contacts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('phone_number');
            $table->string('status')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user_app')->onDelete('set null');
        


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_app_contacts');
    }
};
