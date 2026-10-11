<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WhatsappApi\AiUsageLog;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'phone_number',
        'ai_monthly_budget_usd',
    ];

    protected $casts = [
        'ai_monthly_budget_usd' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function agents() { return $this->hasMany(\App\Models\WhatsappApi\Agent::class); }
    public function userApps() { return $this->hasMany(\App\Models\UserApp::class); }
    public function leads() { return $this->hasMany(\App\Models\WhatsappApi\Lead::class); }
    public function conversations() { return $this->hasMany(\App\Models\WhatsappApi\Conversation::class); }

    /**
     * Consulta limpia a los logs de IA que pertenecen a este proyecto.
     */
    public function aiUsageLogs()
    {
        return AiUsageLog::whereHas('message.conversation', function ($query) {
            $query->where('project_id', $this->id);
        });
    }

    /**
     * Obtiene el gasto total acumulado en USD durante el mes en curso.
     */
    public function currentMonthAiExpense(): float
    {
        return (float) $this->aiUsageLogs()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('cost_usd');
    }

    /**
     * Verifica si el proyecto aún cuenta con presupuesto de IA disponible.
     */
    public function hasAvailableAiBudget(): bool
    {
        return $this->currentMonthAiExpense() < (float) $this->ai_monthly_budget_usd;
    }
}
