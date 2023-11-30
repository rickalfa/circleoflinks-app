<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta_laboral extends Model
{
    use HasFactory;



    public function empresa()
    {

        return $this->belongsTo('App\Models\Empresa');


    }

    public function userOfertaLaboral()
    {

        return $this->belongsTo('App\Models\UserOfertaLaboral', 'user_oferta_laboral_id', 'id');


    }

    public function statusOfertaLaboral()
    {

        return $this->belongsTo('App\Models\Status_oferta_laboral','status_oferta_laboral_id', 'id');

    }

}
