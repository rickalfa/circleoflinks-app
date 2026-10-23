<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WhatsappApi\Conversation;
use App\Http\Controllers\WhatsappApi\WspSendMessageController;
use App\Models\WhatsappApi\Lead;
use Illuminate\Support\Facades\Log;
use Exception;

class ChatLeadController extends Controller
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

    public function sendmessage(Request $request)
    {
        // SEGURIDAD: antes aceptaba cualquier 'phone' desde el cliente, lo que permitía
        // enviar mensajes desde el número de la empresa a cualquier teléfono.
        // Ahora se exige un lead propio y el destino se toma de la BD.
        $request->validate([
            'lead_id' => 'required|integer',
            'message' => 'required|string|max:4096',
        ]);

        $Lead = Lead::ownedBy($request->user())->findOrFail((int) $request->lead_id);

        if (!$Lead->phone_number) {
            return response()->json(['message' => 'El lead no tiene número de teléfono.'], 422);
        }

        $SendMessage = new WspSendMessageController();

        $succes_msg = $SendMessage->sendMessageWsp($request->message, $Lead->phone_number);

        return $succes_msg;
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_lead)
    {
        // SEGURIDAD: solo leads de los proyectos del usuario autenticado (404 si no le pertenece)
        $Lead = Lead::ownedBy(auth()->user())->findOrFail((int) $id_lead);

        try {

            $User = $Lead->user;

            $conversations = $User
                ? Conversation::where('user_id', $User->id)->latest()->first()
                : null;
    

            if ($conversations && method_exists($conversations, 'messages') && $conversations->messages != null) {
                
                return view('whatsapp_service.leads.chat', compact('conversations', 'Lead'));
    
            }else{

                return response()->json([
                    'message' => "no se encontraron conversaciones del Lead "
                ], 422);
               
            }

         

        } catch (Exception $th) {

            // SEGURIDAD: no exponer detalles internos de la excepción al cliente
            Log::error('ChatLeadController@create: ' . $th->getMessage(), ['lead_id' => $Lead->id]);

            return response()->json([
                'message' => 'No se pudo cargar el chat del Lead.'
            ], 500);

        }
   

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
        //
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
