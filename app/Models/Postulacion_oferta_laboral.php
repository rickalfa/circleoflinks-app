<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion_oferta_laboral extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'description',
        'date_expire',
        'oferta_laboral_id'

    ];

    public function ofertalaboral(){

        return $this->belongsTo('App\Models\Oferta_laboral', 'oferta_laboral_id', 'id');


    }


}
