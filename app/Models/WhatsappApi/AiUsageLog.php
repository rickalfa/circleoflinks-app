<?php

namespace App\Models\WhatsappApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiUsageLog extends Model
{
    use HasFactory;

    protected $table = 'ai_usage_logs';

    protected $fillable = [
        'message_id',
        'provider',
        'model',
        'prompt_tokens',
        'completion_tokens',
        'cost_usd',
    ];

    protected $casts = [
        'prompt_tokens' => 'integer',
        'completion_tokens' => 'integer',
        'cost_usd' => 'decimal:6',
    ];

    /**
     * Mensaje al que pertenece este consumo (1-a-1).
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Acceso indirecto a la conversación sin duplicar FK.
     */
    public function conversation()
    {
        return $this->message ? $this->message->conversation : null;
    }

    /**
     * Acceso indirecto al proyecto sin duplicar FK.
     */
    public function project()
    {
        return $this->conversation() ? $this->conversation()->project : null;
    }

    /**
     * Acceso indirecto al agente sin duplicar FK.
     */
    public function agent()
    {
        return $this->conversation() ? $this->conversation()->agent : null;
    }
}
