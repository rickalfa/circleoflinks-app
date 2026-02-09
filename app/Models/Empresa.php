<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';

    protected $fillable = [

        'name',
        'email',
        'avatar',
        'address',
        'rubro'

    ];



    public function oferta_laborals()
    {

        return $this->hasMany('App\Models\Oferta_laboral', 'empresa_id', 'id');


    }


}
