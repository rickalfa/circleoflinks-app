<?php

namespace App\Models\WhatsappApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserApp;

class Conversation extends Model
{
    use HasFactory;


    protected $table = 'conversations';

    protected $fillable = [
        'user_id',
        'agent_id',
        'message',
        'type', // 'user', 'agent'
        'status',
        'assigned_user_id', // users que esta atendiendo la conversacion
        'created_at',
        'updated_at',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(UserApp::class, 'user_id', 'id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_user_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }
}
