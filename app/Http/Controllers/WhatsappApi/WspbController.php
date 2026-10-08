<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use App\Services\WhatsappApi\ConversationWsp;
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
        // 1. Validación de Seguridad (Firma de Meta)
        $secret = env('WHATSAPP_APP_SECRET');
        $signature = $request->header('X-Hub-Signature-256');
        
        if ($secret && $signature) {
            $payload = $request->getContent();
            $expectedHash = 'sha256=' . hash_hmac('sha256', $payload, $secret);
            if (!hash_equals($expectedHash, $signature)) {
                Log::warning('Firma de Meta inválida. Se rechazó el webhook.');
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } elseif ($secret && !$signature) {
            Log::warning('Webhook recibido sin firma de Meta.');
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $data = $request->all();
        $this->dates_message = $data;

        // 2. Deduplicación de mensajes (Meta reintenta si tardamos en responder)
        $wamid = $data['entry'][0]['changes'][0]['value']['messages'][0]['id'] ?? null;
        if ($wamid) {
            // Cache::add devuelve true solo si la clave NO existía.
            if (!\Illuminate\Support\Facades\Cache::add('wamid_' . $wamid, true, now()->addDay())) {
                Log::info("Mensaje duplicado ignorado (ya procesado): {$wamid}");
                return response('OK', 200); // Respondemos a Meta sin procesar
            }
        }

        Log::info('WhatsApp Webhook dates message Request:', $data);

        if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
          $messageBody = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];
          $messageBodyAsString = (string) $messageBody;

         if(isset($messageBodyAsString)){
          Log::info('WhatsApp message user : ' . $messageBodyAsString);
         }else{
          Log::info('Message no Encontrado :  $messageBodyAsString');
         }
        }

        $convessation = new ConversationWsp($data);
        $convessation->startConversation();

        return response('OK', 200);
      }

     



}
