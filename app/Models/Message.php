<?php

namespace App\Models;

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
        'sent_at'];

    public function conversation()
    {
        return $this->belongsTo('conversations', 'conversation_id', 'id');
    }

    public function sender()
    {
        return $this->morphTo();
    }

}
