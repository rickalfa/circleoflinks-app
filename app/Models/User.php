<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\HasPlanLimits;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPlanLimits;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'avatar',
        'status_user_id',
        'phone',
        'plan',
        'onboarding_completed',
    ];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


   protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // <--- Laravel lo encriptará solo al guardar
        'onboarding_completed' => 'boolean',
    ];
}


    public function UserStatus()
    {
        return $this->belongsTo('App\Models\Status_user', 'status_user_id');

    }

   

    public function UserOfertasLaborals()
    {
        return $this->hasOne('App\Models\UserOfertaLaboral');

    }

    /**
     * Relación con proyectos a través de las compañías del usuario.
     */
    public function projects()
    {
        return $this->hasManyThrough(Project::class, Company::class);
    }

    /**
     * Obtiene el proyecto actual activo del usuario.
     */
    public function currentProject(): ?Project
    {
        $sessionProjectId = session('current_project_id');
        if ($sessionProjectId) {
            $project = $this->projects()->where('projects.id', $sessionProjectId)->first();
            if ($project) {
                return $project;
            }
        }
        return $this->projects()->first();
    }

    /**
     * Usuario Tipo A: Tiene proyecto configurado con número de celular para el servicio de conversaciones.
     */
    public function isTypeA(): bool
    {
        return $this->projects()->whereNotNull('phone_number')->exists();
    }

    /**
     * Usuario Tipo B: No suscrito o sin proyecto / celular configurado.
     */
    public function isTypeB(): bool
    {
        return !$this->isTypeA();
    }

    /**
     * Alias para saber si tiene el servicio activo.
     */
    public function hasActiveService(): bool
    {
        return $this->isTypeA();
    }
}
