<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;


    protected $table = 'conversations';

    protected $fillable = [
        'user_id',
        'agent_id',
        'message',
        'type', // 'user', 'agent'
        'created_at',
        'updated_at',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
