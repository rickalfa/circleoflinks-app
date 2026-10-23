<?php

namespace App\Models\WhatsappApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserApp;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'phone_number',
        'last_message_time',
        'state',
        'user_id',
        'avatar_url',
        'has_unread_messages',
        'unread_messages_count',
    ];


    public function user(){

        return $this->belongsTo(UserApp::class, 'user_id', 'id');

    }


    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class);
    }

    /**
     * Última conversación registrada para el UserApp asociado a este Lead.
     */
    public function latestConversation()
    {
        return $this->hasOne(Conversation::class, 'user_id', 'user_id')->latestOfMany('id');
    }


    /**
     * Obtiene la instancia del proyecto al que pertenece este modelo.
     */
    public function currentProject()
    {
        return $this->project;
    }


    /**
     * Restringe la consulta a los Leads que pertenecen a los proyectos del usuario.
     *
     * SEGURIDAD: Usar SIEMPRE este scope al buscar un Lead a partir de un ID
     * recibido desde el cliente, para evitar acceso entre cuentas (IDOR).
     *
     * Uso: Lead::ownedBy($user)->findOrFail($id);
     */
    public function scopeOwnedBy($query, \App\Models\User $user)
    {
        return $query->whereIn('project_id', $user->accessibleProjectIds());
    }

}
