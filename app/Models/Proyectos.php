<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    use HasFactory;


    protected $fillable = [

    'name',
    'description',
    'date_finish',
    'empresa_id'


    ];



    public function empresa()
    {

      return $this->belongsTo('App\Models\Empresa');

    }

}
