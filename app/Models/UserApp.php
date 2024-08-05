<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class UserApp extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user_app';

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'avatar'
    ];

    protected $hidden = [
        'password'
    ];

    public function StatusUserApp()
    {

        return $this->belongsTo('App\Models\UserAppStatus', 'user_app_status_id');

    }

    public function lead()
    {

        return $this->hasOne('App\Models\Whatsappservice\lead','user_id', 'id');

    }
    
    public function UserPerfil()
    {

        return $this->hasOne('App\Models\User_perfil', 'user_id', 'id');


    }

    public function contact()
     {
        
        return $this->hasOne(UserAppContact::class, 'user_id');
     
    }
    
    
    public function Conversations()
    {

        return $this->hasMany('App\Models\Conversation', 'user_id', 'id');


    }


    public static function getUserAppIdsWithContact()
    {
        return self::has('contact')->pluck('id');
    }

}
