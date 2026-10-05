<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'phone_number',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function agents() { return $this->hasMany(\App\Models\WhatsappApi\Agent::class); }
    public function userApps() { return $this->hasMany(\App\Models\UserApp::class); }
    public function leads() { return $this->hasMany(\App\Models\WhatsappApi\Lead::class); }
    public function conversations() { return $this->hasMany(\App\Models\WhatsappApi\Conversation::class); }

}
