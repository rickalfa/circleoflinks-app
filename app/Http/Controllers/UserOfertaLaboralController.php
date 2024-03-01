<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

use App\Models\UserOfertaLaboral;
use App\Http\Requests\StoreUserOfertaLaboralRequest;
use App\Http\Requests\UpdateUserOfertaLaboralRequest;

class UserOfertaLaboralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $UserOfertaLaborls =UserOfertaLaboral::all();

        return $UserOfertaLaborls->toJson();
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
     * @param  \App\Http\Requests\StoreUserOfertaLaboralRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserOfertaLaboralRequest $request)
    {
    
       
        $datesInputs =[
            'user_id'=> 'required|exists:App\Models\User,id',
            'oferta_laboral_id'=> 'required|exists:App\Models\UserOfertaLaboral,id'

        ];

        $UserOfertaLaboral = UserOfertaLaboral::create($datesInputs);

        
        if(isset($UserOfertaLaboral->id))
        {
            $response = ['created'=>'done'];

            return json_encode($response);

        }else{

            
            $response = ['created'=>'fail'];

            return json_encode($response);


        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $UserOfertaLaboral = UserOfertaLaboral::findorfail($id);


        return $UserOfertaLaboral;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function edit(UserOfertaLaboral $userOfertaLaboral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserOfertaLaboralRequest  $request
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserOfertaLaboralRequest $request, UserOfertaLaboral $userOfertaLaboral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserOfertaLaboral  $userOfertaLaboral
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOfertaLaboral $userOfertaLaboral)
    {
        //
    }
}
