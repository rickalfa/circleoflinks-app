<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPerfil extends Model
{

    use HasFactory;

    protected $table = 'user_perfil';

    protected $fillable = [

        'info',
        'education',
        'exp_laboral',
        'habilidades',
        'profetion_name',
        'user_id'
    ];


    


    public function userapp(){


        return $this->belongsTo('App\models\UserApp', 'user_id');


    }

}
