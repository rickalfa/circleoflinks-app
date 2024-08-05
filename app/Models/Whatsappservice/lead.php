<?php

namespace App\Models\Whatsappservice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lead extends Model
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

        return $this->belongsTo('App\Models\UserApp', 'user_id', 'id');




    }

}
