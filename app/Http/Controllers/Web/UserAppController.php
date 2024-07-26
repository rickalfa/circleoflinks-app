<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Conversation;


use App\Models\UserApp;
use Exception;

class UserAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $users = UserApp::all(); // Obtener todos los usuarios
        return view('user.index', compact('users'));

    }

    public function conversations($id){

     
           $user = UserApp::findOrFail($id);
           $conversationsuser = Conversation::where('user_id', '=', $id )->get();

        //  dd($conversationsuser );

           return view('whatsapp_service.userconversation.index', compact('conversationsuser'));
    
            
    
    }

    public function conversationDetail($id){

        $conversations = Conversation::findOrFail($id);



        return view('whatsapp_Service.userconversation.show', compact('conversations'));



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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
            // Buscar el usuario con el ID especificado
    $user = UserApp::find($id);

    // Si el usuario no existe, devolver un error
    if (!$user) {
        return abort(404);
    }

    // Mostrar la vista del usuario con los datos del usuario encontrado
    return view('user.show', ['user' => $user]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
