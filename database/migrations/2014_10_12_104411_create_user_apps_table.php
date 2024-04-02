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
        Schema::create('user_app', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('password');

            $table->timestamp('email_verified_at')->nullable();
         
            
            $table->unsignedBigInteger('user_app_status_id');


            $table->foreign('user_app_status_id')->references('id')->on('user_app_status');
            
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
        Schema::dropIfExists('user_app');
    }
};
