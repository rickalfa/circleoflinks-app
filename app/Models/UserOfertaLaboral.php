<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOfertaLaboral extends Model
{
    use HasFactory;


    public function user()
    {

        return $this->belongsTo('App\Models\Users', 'user_id', 'id');

    }

    public function ofertaLaborals()
    {

        return $this->hasMany('App\Models\Oferta_laboral', 'user_oferta_laboral_id', 'id');

    }

}
