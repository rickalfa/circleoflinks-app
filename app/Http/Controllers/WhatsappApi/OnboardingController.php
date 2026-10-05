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

        // Si ya es un usuario Tipo A (proyecto activo y celular configurado), redirigir
        if ($user && $user->isTypeA()) {
            return redirect()->route('admindashboard')->with('info', 'Ya cuentas con un proyecto activo configurado.');
        }

        return view('whatsapp_service.onboarding.setup');
    }

    /**
     * Procesa y guarda los datos de Empresa, Proyecto y Teléfono para Conversaciones de Servicio.
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
            'project_phone' => 'required|string|max:25',
        ], [
            'company_name.required' => 'El nombre de la empresa es obligatorio.',
            'project_name.required' => 'El nombre del proyecto es obligatorio.',
            'project_phone.required' => 'El número de celular para el servicio de conversaciones es obligatorio.',
        ]);

        DB::beginTransaction();

        try {
            // 1. Obtener o crear Empresa
            $company = $user->companies()->first();
            if (!$company) {
                $company = Company::create([
                    'user_id' => $user->id,
                    'name' => $validated['company_name'],
                    'industry' => $validated['company_industry'],
                    'tax_id' => $validated['company_tax_id'],
                ]);
            } else {
                $company->update([
                    'name' => $validated['company_name'],
                    'industry' => $validated['company_industry'],
                    'tax_id' => $validated['company_tax_id'],
                ]);
            }

            // 2. Crear o actualizar Proyecto
            $project = $company->projects()->first();
            if (!$project) {
                $project = Project::create([
                    'company_id' => $company->id,
                    'name' => $validated['project_name'],
                    'description' => $validated['project_description'],
                    'phone_number' => $validated['project_phone'],
                ]);
            } else {
                $project->update([
                    'name' => $validated['project_name'],
                    'description' => $validated['project_description'],
                    'phone_number' => $validated['project_phone'],
                ]);
            }

            // 3. Marcar usuario como onboarding completado (Usuario Tipo A)
            $user->onboarding_completed = true;
            if (empty($user->plan)) {
                $user->plan = 'free';
            }
            $user->save();

            DB::commit();

            return redirect()->route('admindashboard')
                ->with('success', '¡Servicio "Conversaciones de Servicio" activado con éxito! Tu proyecto y número de WhatsApp han sido configurados.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al guardar la configuración: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Permite al usuario saltar el Onboarding y entrar al dashboard como Usuario Tipo B (Sin proyecto activo).
     */
    public function skip(Request $request)
    {
        $user = $request->user();
        $user->onboarding_completed = true;
        if (empty($user->plan)) {
            $user->plan = 'free';
        }
        $user->save();

        return redirect()->route('admindashboard')
            ->with('warning', 'Has ingresado en modo sin proyecto configurado (Usuario Tipo B). Puedes activar tu servicio gratuito de Conversaciones de WhatsApp en cualquier momento desde el menú lateral.');
    }
}
