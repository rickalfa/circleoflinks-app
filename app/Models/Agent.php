<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'json_logic_response',
        'description',
        'version',
        'status'
    ];


    public function conversations()
    {

        return $this->hasMany('App\Models\Conversation', 'agent_id', 'id');



    }


    public function logicResponses()
    {


        return $this->hasMany('App\Models\LogicResponse', 'agent_id', 'id');

    }



}
