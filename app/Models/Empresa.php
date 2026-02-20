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



    public function ofertalaboral()
    {

        return $this->hasMany('App\Models\OfertaLaboral', 'empresa_id', 'id');


    }


}
