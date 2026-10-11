<?php

namespace App\Models\WhatsappApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'json_logic_response',
        'description',
        'version',
        'status',
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
    ];

    protected $casts = [
        'ai_enabled' => 'boolean',
        'temperature' => 'float',
    ];

    protected $attributes = [
        'status' => 'active',
        'ai_enabled' => false,
        'ai_provider' => 'gemini',
        'ai_model' => 'gemini-2.5-flash-lite',
        'tone' => 'cercano',
        'temperature' => 0.70,
    ];

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'agent_id', 'id');
    }

    public function logicResponses()
    {
        return $this->hasMany(LogicResponse::class, 'agent_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class);
    }

    /**
     * Obtiene la instancia del proyecto al que pertenece este modelo.
     */
    public function currentProject()
    {
        return $this->project;
    }

    /**
     * Obtiene los logs de consumo generados por este agente a través de sus mensajes.
     */
    public function aiUsageLogs()
    {
        return AiUsageLog::whereHas('message.conversation', function ($query) {
            $query->where('agent_id', $this->id);
        });
    }
}
