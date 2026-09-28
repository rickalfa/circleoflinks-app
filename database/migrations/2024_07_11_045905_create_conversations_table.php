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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->string('type')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('agent_id');


            $table->foreign('user_id')->references('id')->on('user_app');

            
            $table->foreign('agent_id')->references('id')->on('agents');






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
        Schema::dropIfExists('conversations');
    }
};
