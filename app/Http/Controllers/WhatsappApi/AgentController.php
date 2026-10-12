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
        $project = auth()->user()->currentProject();
        $projectId = $project ? $project->id : null;
        
        $Bots = Agent::where('project_id', $projectId)->paginate(10); 
        return view('whatsapp_service.agent.index', compact('Bots'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('whatsapp_service.agent.create');

    }

    /**
     * 
     */
    public function activesBots(Request $request){
        $project = auth()->user()->currentProject();
        $projectId = $project ? $project->id : null;

        $Bots = Agent::where('project_id', $projectId)->paginate(10); 

        $pass_var = isset($success);


        if ($pass_var) {

            $success = "";

        } else {
            $success = $request->success;
        }
        

        echo $request->success;

        return view('whatsapp_service.agent.actives', compact('Bots'))->with('success', $success);


    } 

    public function createlogicresponse($Agent)
    {
        $projectId = auth()->user()->currentProject()?->id;
        $agent = Agent::where('project_id', $projectId)->findOrFail($Agent);

        return view('whatsapp_service.agent.createlogicresponse', compact('agent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAgentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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

        $dates_request = $request->all();

        // Convertir checkbox HTML a booleano
        $dates_request['ai_enabled'] = $request->has('ai_enabled');

        if (empty($dates_request['status'])) {
            $dates_request['status'] = 'active';
        }

        if (auth()->check() && auth()->user()->currentProject()) {
            $dates_request['project_id'] = auth()->user()->currentProject()->id;
        }

        $Agent = Agent::create($dates_request);

        return redirect()->route('/admindashboard/bots-r-logicresponsecreate',compact('Agent'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WhatsappApi\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projectId = auth()->user()->currentProject()?->id;
        $Bot = Agent::where('project_id', $projectId)->findOrFail($id);
        
        return view('whatsapp_service.agent.show')->with('Bot', $Bot);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WhatsappApi\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projectId = auth()->user()->currentProject()?->id;
        $Bot = Agent::where('project_id', $projectId)->findOrFail($id);

        return view('whatsapp_service.agent.edit', compact('Bot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgentRequest  $request
     * @param  \App\Models\WhatsappApi\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         try {
          
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
            
            $data = $request->all();
            $data['ai_enabled'] = $request->has('ai_enabled');
    
            $projectId = auth()->user()->currentProject()?->id;
            $bot = Agent::where('project_id', $projectId)->findOrFail($id);

            $bot->update($data);
    
            return redirect()->route('/admindashboard/bots-r/', $id)
                              ->with('success', '¡Bot y configuración de IA actualizados correctamente!');
                            
       
         } catch (Exception $th) {
            
            return redirect()->back()->withInput()
                             ->with('error', 'No se pudo actualizar: ' . $th->getMessage());
         }
  


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WhatsappApi\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        //
    }
}
