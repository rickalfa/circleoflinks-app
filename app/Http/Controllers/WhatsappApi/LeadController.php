<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Models\WhatsappApi\Lead;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreleadRequest;
use App\Http\Requests\UpdateleadRequest;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Si el usuario es Tipo B (sin proyecto o servicio activo), invitarlo a activar el servicio
        if ($user && $user->isTypeB()) {
            return redirect()->route('onboarding.setup')
                ->with('warning', 'Para acceder al módulo de Leads debes activar el servicio de WhatsApp y registrar tu número de celular.');
        }
        
        // Obtenemos solo los Leads que pertenecen a los proyectos de las compañías del usuario
        $Leads = Lead::ownedBy($user)->latest()->get();

        return view('whatsapp_service.leads.index', compact('Leads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreleadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreleadRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WhatsappApi\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WhatsappApi\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateleadRequest  $request
     * @param  \App\Models\WhatsappApi\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateleadRequest $request, Lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WhatsappApi\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        //
    }
}
