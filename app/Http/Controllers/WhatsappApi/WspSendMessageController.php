<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WspSendMessageController extends Controller
{
    

    
    private $dates_message = "";



    public function sendmessage(Request $request){


        $mensaje = $request->message;
        $number_to = $request->numberto;

        $response_sendm = $this->sendMessageWsp($mensaje, $number_to);
              


        echo $response_sendm;
   

      }


    
      /**
       * Summary of sendMessageWsp 
       *      Envio de Mensajes a numero especifico 
       * @param mixed $mensaje
       * @param mixed $numberTo
       * @return void
       */
      protected function sendMessageWsp($mensaje, $numberTo){

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
