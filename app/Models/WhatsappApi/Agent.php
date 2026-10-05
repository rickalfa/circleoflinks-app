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
        'status'
    ];

    protected $attributes = [
        'status' => 'active',
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

}
