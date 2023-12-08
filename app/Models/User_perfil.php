<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_perfil extends Model
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


    


    public function user(){


        return $this->belongsTo('App\models\User', 'user_id');


    }

}
