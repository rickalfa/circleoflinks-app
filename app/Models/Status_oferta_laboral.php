<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_oferta_laboral extends Model
{

   


    use HasFactory;


    public function ofertaLaboral()
    {
        return $this->belongsTo('App\Models\Oferta_laboral');

    }


}
