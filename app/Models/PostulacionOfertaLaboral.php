<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostulacionOfertaLaboral extends Model
{
    use HasFactory;

    protected $table = 'postulacion_oferta_laborales';

    protected $fillable = [

        'name',
        'description',
        'date_expire',
        'oferta_laboral_id'

    ];

    public function ofertalaboral(){

        return $this->belongsTo('App\Models\OfertaLaboral', 'oferta_laboral_id', 'id');


    }


}
