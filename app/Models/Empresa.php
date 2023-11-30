<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{

    protected $table = 'empresa';

    use HasFactory;



    public function ofertaLaboral()
    {

        return $this->hasMany('App\Models\Oferta_laboral', 'empresa_id', 'id');



    }


}
