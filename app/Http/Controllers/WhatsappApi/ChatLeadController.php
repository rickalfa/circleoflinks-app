<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Conversation;
use App\Http\Controllers\WhatsappApi\WspSendMessageController;
use App\Models\Whatsappservice\lead;
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
 
        $message = $request->message;

        $phone = $request->phone;

       // dd($phone);



        $SendMessage = new WspSendMessageController();


        $succes_msg = $SendMessage->sendMessageWsp($message, $phone);

       

        return $succes_msg;
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_lead)
    {
        try {
            
            $Lead = Lead::findOrFail($id_lead);

            $User = $Lead->user;
    
            $conversations = Conversation::where('user_id', $User->id)->latest()->first();
    

            if ($conversations && method_exists($conversations, 'messages') && $conversations->messages != null) {
                
                return view('whatsapp_service.leads.chat', compact('conversations'));
    
            }else{

                return response()->json([
                    'message' => "no se encontraron conversaciones del Lead "
                ], 422);
               
            }

         

        } catch (Exception $th) {
            
            return response()->json([
                'message' => "<p>".$th->getMessage()
            ], 422);

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
