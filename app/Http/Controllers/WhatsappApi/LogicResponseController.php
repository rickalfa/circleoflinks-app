<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Models\WhatsappApi\LogicResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLogicResponseRequest;
use App\Http\Requests\UpdateLogicResponseRequest;
use App\Models\WhatsappApi\Agent;
use Illuminate\Http\Request;

class LogicResponseController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param int $idagent
     * @return \Illuminate\Http\Response
     */
    public function create($idagent)
    {
        $agent = Agent::findOrFail($idagent);

        $this->authorize('update', $agent);

        return view('whatsapp_service.logicresponse.create', compact('agent'))->with('idagent', $idagent);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'agent_id'    => 'required|exists:agents,id',
            'name'        => 'required|string|max:255',
            'key_trigger' => 'required|string|max:255',
            'response'    => 'required|string|max:220',
        ]);

        $agent = Agent::findOrFail($request->agent_id);

        $this->authorize('update', $agent);

        // Validar límite de respuestas/reglas del plan
        $currentRulesCount = LogicResponse::whereHas('agent', function ($query) use ($agent) {
            $query->where('project_id', $agent->project_id);
        })->count();

        if (!auth()->user()->canCreateMoreBots($currentRulesCount)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Has alcanzado el límite de 100 reglas lógicas para el plan Gratuito. Actualiza a Premium para crear reglas ilimitadas.');
        }

        $data = $request->all();

        LogicResponse::create($data);

        return redirect()->route('/admindashboard/bots-r/', ['id' => $data['agent_id']])
            ->with('success', 'Respuesta lógica creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WhatsappApi\LogicResponse  $logicResponse
     * @return \Illuminate\Http\Response
     */
    public function show(LogicResponse $logicResponse)
    {
        $this->authorize('view', $logicResponse);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WhatsappApi\LogicResponse  $logicResponse
     * @return \Illuminate\Http\Response
     */
    public function edit(LogicResponse $logicResponse)
    {
        $this->authorize('update', $logicResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WhatsappApi\LogicResponse  $logicResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogicResponse $logicResponse)
    {
        $this->authorize('update', $logicResponse);

        $request->validate([
            'name'        => 'required|string|max:255',
            'key_trigger' => 'required|string|max:255',
            'response'    => 'required|string|max:220',
        ]);

        $logicResponse->update($request->all());

        return redirect()->back()->with('success', 'Respuesta lógica actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WhatsappApi\LogicResponse  $logicResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogicResponse $logicResponse)
    {
        $this->authorize('delete', $logicResponse);

        $agentId = $logicResponse->agent_id;
        $logicResponse->delete();

        return redirect()->route('/admindashboard/bots-r/', ['id' => $agentId])
            ->with('success', 'Regla eliminada exitosamente.');
    }
}
