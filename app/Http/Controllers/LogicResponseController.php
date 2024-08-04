<?php

namespace App\Http\Controllers;

use App\Models\LogicResponse;
use App\Http\Requests\StoreLogicResponseRequest;
use App\Http\Requests\UpdateLogicResponseRequest;

use App\Models\Agent;

use Illuminate\Http\Request;

class LogicResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idagent)
    {

         $agent = Agent::findOrFail($idagent);


        
        return view('whatsapp_service.logicresponse.create', compact('agent'))->with('idagent', $idagent);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLogicResponseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    

        $request->validate([
            'name' => 'required|string|max:255',
            'key_trigger' => 'required|string|max:255',
            'response' => 'required|string|max:220',
        ]);

        $data = $request->all();

    
        LogicResponse::create($request->all());
    
        return redirect()->route('/admindashboard/bots-r/',['id' => $data['agent_id'] ])
                         ->with('success', 'Response created successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogicResponse  $logicResponse
     * @return \Illuminate\Http\Response
     */
    public function show(LogicResponse $logicResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogicResponse  $logicResponse
     * @return \Illuminate\Http\Response
     */
    public function edit(LogicResponse $logicResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLogicResponseRequest  $request
     * @param  \App\Models\LogicResponse  $logicResponse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLogicResponseRequest $request, LogicResponse $logicResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogicResponse  $logicResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogicResponse $logicResponse)
    {
        //
    }
}
