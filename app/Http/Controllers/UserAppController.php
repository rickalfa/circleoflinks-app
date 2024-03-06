<?php

namespace App\Http\Controllers;

use App\Models\UserApp;
use App\Http\Requests\StoreUserAppRequest;
use App\Http\Requests\UpdateUserAppRequest;

class UserAppController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserAppRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserAppRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserApp  $userApp
     * @return \Illuminate\Http\Response
     */
    public function show(UserApp $userApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserApp  $userApp
     * @return \Illuminate\Http\Response
     */
    public function edit(UserApp $userApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserAppRequest  $request
     * @param  \App\Models\UserApp  $userApp
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserAppRequest $request, UserApp $userApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserApp  $userApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserApp $userApp)
    {
        //
    }
}
