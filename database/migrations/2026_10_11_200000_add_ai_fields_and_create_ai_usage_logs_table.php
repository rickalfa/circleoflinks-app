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
        // 1. Campos de configuración de IA y personalidad en tabla `agents`
        Schema::table('agents', function (Blueprint $table) {
            $table->boolean('ai_enabled')->default(false)->after('status');
            $table->string('ai_provider', 50)->default('gemini')->after('ai_enabled');
            $table->string('ai_model', 100)->default('gemini-2.5-flash-lite')->after('ai_provider');
            $table->string('persona_name', 100)->nullable()->after('ai_model');
            $table->string('role', 150)->nullable()->after('persona_name');
            $table->string('tone', 50)->default('cercano')->after('role');
            $table->text('personality')->nullable()->after('tone');
            $table->text('backstory')->nullable()->after('personality');
            $table->longText('knowledge_base')->nullable()->after('backstory');
            $table->text('style_rules')->nullable()->after('knowledge_base');
            $table->text('boundaries')->nullable()->after('style_rules');
            $table->decimal('temperature', 3, 2)->default(0.70)->after('boundaries');
        });

        // 2. Presupuesto mensual en tabla `projects`
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('ai_monthly_budget_usd', 8, 2)->default(10.00)->after('phone_number');
        });

        // 3. Tabla normalizada de auditoría y consumo de tokens (Opción B: 3NF vinculada a message_id)
        Schema::create('ai_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->unique()->constrained('messages')->cascadeOnDelete();
            $table->string('provider', 50); // 'gemini', 'openai'
            $table->string('model', 100);    // 'gemini-2.5-flash-lite'
            $table->unsignedInteger('prompt_tokens')->default(0);
            $table->unsignedInteger('completion_tokens')->default(0);
            $table->decimal('cost_usd', 10, 6)->default(0.000000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_usage_logs');

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('ai_monthly_budget_usd');
        });

        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'ai_enabled',
                'ai_provider',
                'ai_model',
                'persona_name',
                'role',
                'tone',
                'personality',
                'backstory',
                'knowledge_base',
                'style_rules',
                'boundaries',
                'temperature',
            ]);
        });
    }
};
