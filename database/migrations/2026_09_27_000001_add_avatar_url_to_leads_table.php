<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Añade la columna avatar_url a la tabla leads para almacenar
     * la URL de la foto de perfil de WhatsApp del cliente.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('avatar_url')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('avatar_url');
        });
    }
};
