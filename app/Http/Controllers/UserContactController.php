<?php

namespace App\Http\Controllers;

use App\Models\UserContact;
use App\Http\Requests\StoreUserContactRequest;
use App\Http\Requests\UpdateUserContactRequest;

class UserContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $UserContacts = UserContact::all();

        return $UserContacts->toJson();

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
     * @param  \App\Http\Requests\StoreUserContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserContactRequest $request)
    {
        //

        $datesRequest = $request->all();

        $datesInputs = [

            'user_id' => $datesRequest['user_id'],
            'status' => $datesRequest['status'],
            'contact_id' => $datesRequest['contact_id']

        ];

        $UserContact = UserContact::create($datesInputs);

        if(isset($UserContact->id))
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
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Contactos = UserContact::where('id', '=', $id)->first();

        return $Contactos->tojson();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function edit(UserContact $userContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserContactRequest  $request
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserContactRequest $request, UserContact $userContact)
    {
        //

        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserContact  $userContact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $UserContactDelete = UserContact::findorfail($id)->delete();


    }
}
