<?php

namespace App\Models\WhatsappApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserApp;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'phone_number',
        'last_message_time',
        'state',
        'user_id'
    ];


    public function user(){

        return $this->belongsTo(UserApp::class, 'user_id', 'id');

    }

}
