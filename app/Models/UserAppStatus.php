<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAppStatus extends Model
{
    use HasFactory;

    protected $table = 'user_app_status';

    protected $fillable = [
        'name',
        'description'

    ];
}
