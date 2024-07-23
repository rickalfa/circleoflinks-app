<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userAppContact extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'phone_number',
        'status',
        'user_id'
    ];
}
