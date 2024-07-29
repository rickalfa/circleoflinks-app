<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogicResponse extends Model
{
    use HasFactory;


    protected $fillable = [

        'name',
        'key_trigger',
        'response',
        'agent_id'


    ];


    public function Agent(){

        return $this->belongsTo('App\Models\Agent', 'agent_id', 'id');


    }



}
