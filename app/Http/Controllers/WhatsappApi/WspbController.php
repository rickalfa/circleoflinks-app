<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use App\Http\Whatsappservice\Daterecolection\ConversationWsp;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Exception;


class WspbController extends Controller
{
    

    private $dates_message = "";


  /**recepion de comprovacion de TOKEN de 
   * WHATSSAP API CLOUD
   * https://developers.facebook.com/docs/whatsapp/cloud-api/get-started
   */
    public function webhook(Request $request){
        //TOQUEN QUE QUERRAMOS PONER 
   

        try {
          
          Log::info('WhatsApp Webhook Request:', $request->all());

          $query = $request->query();


          $jsondata = json_encode($query);



              // Verificación del webhook
      if ($request->isMethod('get')) {
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

      if ($mode && $token) {
            if ($mode === 'subscribe' && $token === env('WHATSAPP_VERIFY_TOKEN')) {
                // Responde con el reto proporcionado
                return response($challenge, 200);
            } else {
           
            }
        }

      }


        } catch (Exception $th) {
          
          return response()->json(["success" =>false, 'error'=> $th->getMessage()], 400);

          

        }


      }
      /*
      * RECEPCION DE MENSAJES desde WhatsApp  API
      *  
      * Summary of __construct
      * @param mixed $dates
      * el Parametro $dates son los datos enviados por la WhatsApp API Cloud
      * son enviados por e usuario cuando envia un Mensaje al numero Configurado para el projecto 
      * que esta utilizando la API de WhatsApp la documentacion oficial
      *  https://developers.facebook.com/docs/whatsapp/cloud-api/guides/send-messages#solicitudes
      */
      public function recibir(Request $request){
        //LEEMOS LOS DATOS ENVIADOS POR WHATSAPP

          
        Log::info('WhatsApp Webhook dates message Request:', $request->all());

        $data = array();
        

         $data =  $request->all();

         $this->dates_message =$data;


         
         if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
          $messageBody = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];

          // Convertir el valor a string, aunque debería serlo ya
          $messageBodyAsString = (string) $messageBody;

          // Registrar el valor en el log
          Log::info('WhatsApp message user: ' . $messageBodyAsString);

        }


        $convessation = new ConversationWsp($data);

        $convessation->startConversation();

        return "peticion recibir";

      }

     



}
