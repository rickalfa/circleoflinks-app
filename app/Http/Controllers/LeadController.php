<?php

namespace App\Http\Controllers;

use App\Models\Whatsappservice\lead;
use App\Http\Requests\StoreleadRequest;
use App\Http\Requests\UpdateleadRequest;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $Leads = Lead::all();


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
     * @param  \App\Models\Whatsappservice\lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Whatsappservice\lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateleadRequest  $request
     * @param  \App\Models\Whatsappservice\lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateleadRequest $request, lead $lead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Whatsappservice\lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(lead $lead)
    {
        //
    }
}
