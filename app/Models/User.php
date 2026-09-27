<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
    ];

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


}
