<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\userAppContact;
use App\Http\Requests\StoreuserAppContactRequest;
use App\Http\Requests\UpdateuserAppContactRequest;

class UserAppContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $Contacts = UserAppContact::all(); // Obtener todos los usuarios

        

        
        

        return view('whatsapp_service.contact.index', compact('Contacts'));


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
     * @param  \App\Http\Requests\StoreuserAppContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreuserAppContactRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\userAppContact  $userAppContact
     * @return \Illuminate\Http\Response
     */
    public function show(userAppContact $userAppContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\userAppContact  $userAppContact
     * @return \Illuminate\Http\Response
     */
    public function edit(userAppContact $userAppContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateuserAppContactRequest  $request
     * @param  \App\Models\userAppContact  $userAppContact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateuserAppContactRequest $request, userAppContact $userAppContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\userAppContact  $userAppContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(userAppContact $userAppContact)
    {
        //
    }
}
