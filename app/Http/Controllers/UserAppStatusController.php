<?php

namespace App\Http\Controllers;

use App\UserAppStatus;
use App\Http\Requests\StoreUserAppStatusRequest;
use App\Http\Requests\UpdateUserAppStatusRequest;

class UserAppStatusController extends Controller
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
     * @param  \App\Http\Requests\StoreUserAppStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserAppStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserAppStatus  $userAppStatus
     * @return \Illuminate\Http\Response
     */
    public function show(UserAppStatus $userAppStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserAppStatus  $userAppStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAppStatus $userAppStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserAppStatusRequest  $request
     * @param  \App\UserAppStatus  $userAppStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserAppStatusRequest $request, UserAppStatus $userAppStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserAppStatus  $userAppStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAppStatus $userAppStatus)
    {
        //
    }
}
