<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->string('status')->default('bot_active'); // 'bot_active', 'human_active', 'closed'
            $table->unsignedBigInteger('assigned_user_id')->nullable(); // ID del humano atendiendo
            
            // Suponiendo que la tabla de humanos es 'users'
            $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['assigned_user_id']);
            $table->dropColumn('assigned_user_id');
            $table->dropColumn('status');
        });
    }
};
