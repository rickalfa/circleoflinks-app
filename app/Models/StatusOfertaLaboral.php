<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOfertaLaboral extends Model
{
    use HasFactory;

    protected $table = 'status_oferta_laborales';

    protected $fillable = [

        'name',
        'description'

    ];


   


    public function ofertaLaboral()
    {
        return $this->belongsTo('App\Models\OfertaLaboral');

    }


}
