<?php

namespace App\Http\Controllers;

use App\Models\Agent;
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
        $Bots = Agent::paginate(10); // Obtener todos los usuarios
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

        $Bots = Agent::paginate(10); 

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


        //echo 'nombre del nuevo agente '. $Agent->name;
        
      
        $agent = Agent::findOrFail($Agent);



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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'version' => 'required',
        ]);

        $dates_request = $request->all();

       // print_r($dates_request);

        //dd($dates_request);
   

        $Agent = Agent::create($dates_request);

        return redirect()->route('/admindashboard/bots-r-logicresponsecreate',compact('Agent'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Bot = Agent::findOrFail($id);
        

        return view('whatsapp_service.agent.show')->with('Bot', $Bot);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(Agent $agent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAgentRequest  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         try {
          
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'version' => 'required|numeric',
                'status' => 'required|string',
            ]);
            
    
            //dd($request);
    
            $bot = Agent::findOrFail($id);

            $bot->update($request->all());
    
            return redirect()->route('bot.actives')
                              ->with('success', 'se pudo actualizar');
                            
       
         } catch (Exception $th) {
            
            return redirect()->route('bot.actives')
                             ->with('success', ' no se pudo actualizar');


         }
  


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent)
    {
        //
    }
}
