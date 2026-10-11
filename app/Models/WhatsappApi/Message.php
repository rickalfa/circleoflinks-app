<?php

namespace App\Models\WhatsappApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id', 
        'sender_type', 
        'content', 
        'sent_at'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    public function sender()
    {
        return $this->morphTo();
    }

    /**
     * Registro de auditoría y tokens de IA vinculado a este mensaje.
     */
    public function aiUsageLog()
    {
        return $this->hasOne(AiUsageLog::class, 'message_id', 'id');
    }
}
