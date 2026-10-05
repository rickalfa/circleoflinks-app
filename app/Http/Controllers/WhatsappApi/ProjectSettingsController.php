<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectSettingsController extends Controller
{
    /**
     * Muestra la pantalla de configuración del proyecto y número de celular.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $project = $user->currentProject();

        // Si no tiene proyecto configurado (Usuario Tipo B), redirigir a Onboarding
        if (!$project) {
            return redirect()->route('onboarding.setup')->with('warning', 'Aún no tienes un proyecto activo. Configura tu número de WhatsApp para comenzar.');
        }

        $company = $project->company;

        return view('whatsapp_service.project.settings', compact('project', 'company'));
    }

    /**
     * Actualiza los datos del proyecto y el número de celular del servicio.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $project = $user->currentProject();

        if (!$project) {
            return redirect()->route('onboarding.setup');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone_number' => 'required|string|max:25',
            'company_name' => 'nullable|string|max:255',
        ], [
            'name.required' => 'El nombre del proyecto es obligatorio.',
            'phone_number.required' => 'El número de celular para el servicio de conversaciones es obligatorio.',
        ]);

        DB::beginTransaction();

        try {
            $project->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'phone_number' => $validated['phone_number'],
            ]);

            if (!empty($validated['company_name']) && $project->company) {
                $project->company->update([
                    'name' => $validated['company_name'],
                ]);
            }

            DB::commit();

            return redirect()->route('project.settings')->with('success', 'Proyecto y número de teléfono actualizados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el proyecto: ' . $e->getMessage())->withInput();
        }
    }
}
