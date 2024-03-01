<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_user extends Model
{

    protected $table = 'status_user';

    protected $fillable = [

        'name',
        'description'

    ];


    use HasFactory;


    public function Users()
    {


        return $this->hasMany('App\Models\User');

    }

}
