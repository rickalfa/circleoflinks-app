<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Exception;


class WspbController extends Controller
{
    

    private $dates_message;


  /**recepion de comprovacion de TOKEN de 
   * WHATSSAP API CLOUD
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
      * RECEPCION DE MENSAJES
      */
      public function recibir(Request $request){
        //LEEMOS LOS DATOS ENVIADOS POR WHATSAPP

          
        Log::info('WhatsApp Webhook dates message Request:', $request->all());

        $data = array();
        

         $data =  $request->all();

         
         if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
          $messageBody = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];

          // Convertir el valor a string, aunque debería serlo ya
          $messageBodyAsString = (string) $messageBody;

          // Registrar el valor en el log
          Log::info('WhatsApp message user: ' . $messageBodyAsString);

        }



      }

      public function sendmessage(Request $request){


        $mensaje = $request->message;
        $number_to = $request->numberto;

        $response_sendm = $this->sendMessageWsp($mensaje, $number_to);
              


        echo $response_sendm;
   

      }

      public function GetDateMenssageUser(){

        $date_massage_user = $this->dates_message;

        return $date_massage_user;

      }


      public function sendMessageWsp($mensaje, $numberTo){

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://graph.facebook.com/v19.0/275797412294692/messages',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "messaging_product": "whatsapp",
          "to": "'.$numberTo.'",
              "type": "text",
            "text": {
                "body": "'.$mensaje.'"
            }

        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.env('WHATSSAP_API_TOKEN')
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;


      }


}
