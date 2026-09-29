<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    /**
     * Muestra el formulario de configuración inicial (Empresa y Proyecto).
     */
    public function setup(Request $request)
    {
        $user = $request->user();

        // Si ya completó el onboarding, redirigir al dashboard
        if ($user->onboarding_completed) {
            return redirect()->route('admindashboard');
        }

        return view('whatsapp_service.onboarding.setup');
    }

    /**
     * Procesa y guarda los datos de Empresa y Proyecto.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        // Validar campos de ambos pasos
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_industry' => 'nullable|string|max:255',
            'company_tax_id' => 'nullable|string|max:50',
            
            'project_name' => 'required|string|max:255',
            'project_description' => 'nullable|string',
            'project_phone' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            // 1. Crear Empresa
            $company = Company::create([
                'user_id' => $user->id,
                'name' => $validated['company_name'],
                'industry' => $validated['company_industry'],
                'tax_id' => $validated['company_tax_id'],
            ]);

            // 2. Crear Proyecto
            $project = Project::create([
                'company_id' => $company->id,
                'name' => $validated['project_name'],
                'description' => $validated['project_description'],
                'phone_number' => $validated['project_phone'],
            ]);

            // 3. Marcar usuario como onboarding completado
            $user->onboarding_completed = true;
            // Por defecto, si el usuario es nuevo, asumimos que tiene plan "free"
            // (esto ya está en la migración por defecto, pero podemos forzarlo)
            if (empty($user->plan)) {
                $user->plan = 'free';
            }
            $user->save();

            DB::commit();

            return redirect()->route('admindashboard')->with('success', 'Configuración completada con éxito. ¡Bienvenido!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al guardar la configuración: ' . $e->getMessage())->withInput();
        }
    }
}
