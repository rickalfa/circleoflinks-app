<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfertaLaboral extends Model
{
    use HasFactory;

    protected $table = 'ofertas_laborales';

    protected $fillable = [
        'title',
        'name',
        'description',
        'salary',
        'date_expire',
        'status_oferta_laboral_id',
        'empresa_id'
    ];


    public function empresa()
    {

        return $this->belongsTo('App\Models\Empresa');


    }

    public function userOfertaLaboral()
    {

        return $this->belongsTo('App\Models\UserOfertaLaboral', 'user_oferta_laboral_id', 'id');


    }

    public function statusofertalaboral()
    {

        return $this->belongsTo('App\Models\StatusOfertaLaboral','status_oferta_laboral_id', 'id');

    }

}
