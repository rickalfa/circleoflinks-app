<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Models\WhatsappApi\Agent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
use Exception;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Agent::class);

        $project = auth()->user()->currentProject();
        $projectId = $project ? $project->id : null;
        
        $currentBotCount = $projectId ? Agent::where('project_id', $projectId)->count() : 0;
        $canCreateMore = auth()->user()->canCreateMoreBots($currentBotCount);
        $canUseAi = auth()->user()->canUseAiBots();

        $Bots = Agent::where('project_id', $projectId)->paginate(10); 
        return view('whatsapp_service.agent.index', compact('Bots', 'canCreateMore', 'canUseAi', 'currentBotCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Agent::class);

        $canUseAi = auth()->user()->canUseAiBots();

        return view('whatsapp_service.agent.create', compact('canUseAi'));
    }

    /**
     * Formulario de creación para Bot Normal (Reglas de respuesta, sin IA).
     * Disponible para Free y Premium.
     */
    public function createRules()
    {
        $this->authorize('create', Agent::class);

        $project = auth()->user()->currentProject();
        $projectId = $project ? $project->id : null;
        $currentBotCount = $projectId ? Agent::where('project_id', $projectId)->count() : 0;

        if (!auth()->user()->canCreateMoreBots($currentBotCount)) {
            return redirect()->route('/admindashboard/bots-r')
                ->with('error', 'Has alcanzado el límite máximo de bots permitidos en tu plan ' . ucfirst(auth()->user()->plan) . '.');
        }

        return view('whatsapp_service.agent.create_rules');
    }

    /**
     * Formulario de creación para Bot con Inteligencia Artificial (MLL).
     * Exclusivo para Premium.
     */
    public function createMll()
    {
        $this->authorize('create', Agent::class);

        $project = auth()->user()->currentProject();
        $projectId = $project ? $project->id : null;
        $currentBotCount = $projectId ? Agent::where('project_id', $projectId)->count() : 0;

        if (!auth()->user()->canCreateMoreBots($currentBotCount)) {
            return redirect()->route('/admindashboard/bots-r')
                ->with('error', 'Has alcanzado el límite máximo de bots permitidos en tu plan ' . ucfirst(auth()->user()->plan) . '.');
        }

        $canUseAi = auth()->user()->canUseAiBots();

        return view('whatsapp_service.agent.create_mll', compact('canUseAi'));
    }

    /**
     * Listado de bots activos.
     */
    public function activesBots(Request $request)
    {
        $this->authorize('viewAny', Agent::class);

        $project = auth()->user()->currentProject();
        $projectId = $project ? $project->id : null;

        $Bots = Agent::where('project_id', $projectId)
            ->where('status', 'active')
            ->paginate(10); 

        $success = $request->success ?? "";

        return view('whatsapp_service.agent.actives', compact('Bots'))->with('success', $success);
    } 

    public function createlogicresponse($Agent)
    {
        $projectId = auth()->user()->currentProject()?->id;
        $agent = Agent::where('project_id', $projectId)->findOrFail($Agent);

        $this->authorize('update', $agent);

        return view('whatsapp_service.agent.createlogicresponse', compact('agent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Agent::class);

        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'required|string|max:255',
            'version'        => 'required',
            'ai_enabled'     => 'nullable',
            'persona_name'   => 'nullable|string|max:100',
            'role'           => 'nullable|string|max:150',
            'tone'           => 'nullable|string|max:50',
            'personality'    => 'nullable|string',
            'backstory'      => 'nullable|string',
            'knowledge_base' => 'nullable|string',
            'style_rules'    => 'nullable|string',
            'boundaries'     => 'nullable|string',
            'temperature'    => 'nullable|numeric|between:0,1',
        ]);

        $wantsAi = $request->has('ai_enabled') && $request->input('ai_enabled') == '1';

        // Validación estricta en servidor: Bots con IA son exclusivos de Premium
        if ($wantsAi && !auth()->user()->canUseAiBots()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Los bots con Inteligencia Artificial (LLM) son exclusivos del Plan Premium. Actualiza tu suscripción para habilitar esta funcionalidad.');
        }

        $dates_request = $request->all();

        // Convertir checkbox HTML a booleano solo si el plan lo permite
        $dates_request['ai_enabled'] = $wantsAi && auth()->user()->canUseAiBots();

        if (empty($dates_request['status'])) {
            $dates_request['status'] = 'active';
        }

        if (auth()->check() && auth()->user()->currentProject()) {
            $dates_request['project_id'] = auth()->user()->currentProject()->id;
        }

        $Agent = Agent::create($dates_request);

        return redirect()->route('/admindashboard/bots-r-logicresponsecreate', compact('Agent'))
            ->with('success', 'Bot creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projectId = auth()->user()->currentProject()?->id;
        $Bot = Agent::where('project_id', $projectId)->findOrFail($id);

        $this->authorize('view', $Bot);
        
        return view('whatsapp_service.agent.show')->with('Bot', $Bot);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectId = auth()->user()->currentProject()?->id;
        $Bot = Agent::where('project_id', $projectId)->findOrFail($id);

        $this->authorize('update', $Bot);

        $canUseAi = auth()->user()->canUseAiBots();

        return view('whatsapp_service.agent.edit', compact('Bot', 'canUseAi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $projectId = auth()->user()->currentProject()?->id;
            $bot = Agent::where('project_id', $projectId)->findOrFail($id);

            $this->authorize('update', $bot);

            $request->validate([
                'name'           => 'required|string|max:255',
                'description'    => 'required|string',
                'version'        => 'required',
                'status'         => 'required|string',
                'ai_enabled'     => 'nullable',
                'persona_name'   => 'nullable|string|max:100',
                'role'           => 'nullable|string|max:150',
                'tone'           => 'nullable|string|max:50',
                'personality'    => 'nullable|string',
                'backstory'      => 'nullable|string',
                'knowledge_base' => 'nullable|string',
                'style_rules'    => 'nullable|string',
                'boundaries'     => 'nullable|string',
                'temperature'    => 'nullable|numeric|between:0,1',
            ]);
            
            $wantsAi = $request->has('ai_enabled') && $request->input('ai_enabled') == '1';

            // Validación estricta en servidor: Bots con IA son exclusivos de Premium
            if ($wantsAi && !auth()->user()->canUseAiBots()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Los bots con Inteligencia Artificial (LLM) son exclusivos del Plan Premium. Actualiza tu suscripción para habilitar esta funcionalidad.');
            }

            $data = $request->all();
            $data['ai_enabled'] = $wantsAi && auth()->user()->canUseAiBots();

            $bot->update($data);
    
            return redirect()->route('/admindashboard/bots-r/', $id)
                ->with('success', '¡Bot y configuración actualizados correctamente!');
                            
        } catch (Exception $th) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'No se pudo actualizar: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projectId = auth()->user()->currentProject()?->id;
        $bot = Agent::where('project_id', $projectId)->findOrFail($id);

        $this->authorize('delete', $bot);

        $bot->delete();

        return redirect()->route('/admindashboard/bots-r')
            ->with('success', 'Bot eliminado exitosamente.');
    }
}
