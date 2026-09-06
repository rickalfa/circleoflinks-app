<?php

namespace App\Http\Whatsappservice\Daterecolection;

use App\Models\Agent;
use App\Http\Controllers\WhatsappApi\WspbController;
use App\Http\Controllers\WhatsappApi\WspSendMessageController;
use Illuminate\Support\Facades\Log;
use Exception;



Class BotWsp extends WspbController{


    
    private $AgentWsp;
    private $logic_response;
    private $SendMsgWsp;

    private $num_phone = 0;

    public function __constructor(Agent $BotAgentwsp, WspSendMessageController $Sendmsgwsp){


        $this->AgentWsp = $BotAgentwsp;

        $this->SendMsgWsp = $Sendmsgwsp;
        

     }

     public function __construct(){

        $this->AgentWsp = new Agent();

        $this->SendMsgWsp = new WspSendMessageController();

     }
     public function getMessage(){


      
    }

    public function receptionMessage(string $message, string $number_user){
        Log::info("BotWsp receptionMessage: Mensaje recibido: '{$message}' desde el número {$number_user}");

        /**
         * buscamos todas las key_Trigger de los bots Activados
         */
        $this->logic_response = $this->selectResponsesFromBotActive($message);
        $this->num_phone = $number_user;

        if ($this->logic_response) {
            Log::info("BotWsp: Respuesta seleccionada: '{$this->logic_response}'");
        } else {
            Log::info("BotWsp: No se encontró respuesta lógica para el mensaje recibido.");
        }
    }
    
    public function sendWspMessage(){
        if (is_string($this->logic_response) && !empty(trim($this->logic_response))) {
            Log::info("BotWsp: Enviando mensaje al número {$this->num_phone}...");
            $respuesta_bot = $this->SendMsgWsp->sendMessageWsp($this->logic_response, $this->num_phone);
            echo $respuesta_bot;
        } else {
            Log::info("BotWsp sendWspMessage: No se envió mensaje (sin respuesta lógica o vacía).");
        }
    }

    private function logicResponseToMessage($text, $patterns): bool{
        // Escapar caracteres especiales del patrón para uso en expresión regular
        $escapedPatterns = array_map(function($pattern) {
            return preg_quote($pattern, '/');
        }, $patterns);
    
        // Crear una expresión regular que busque cualquiera de los patrones (insensible a mayúsculas /i)
        $regex = '/(' . implode('|', $escapedPatterns) . ')/i';

        if (preg_match($regex, $text)) {
            return true;
        } else {
            return false;
        }
    }

    private function selectResponsesFromBotActive($key_string)
    {
        $BotsActives = Agent::where('status', 'active')->get();
        Log::info("BotWsp: Bots con status 'active' encontrados: " . $BotsActives->count());

        if ($BotsActives->isEmpty()) {
            Log::warning("BotWsp: ¡No hay ningún bot activo en la tabla 'agents'! Ve al panel web y activa un bot.");
            return null;
        }

        $Keys_arr = array();
        $count = 0;

        /**
         * recorrimos el arreglo de Bots que estan con status = 'active'
         */
        foreach($BotsActives as $Bot){
            /**
             * recorrimos el arreglo de Logicresponses que contiene el Bot
             * y comparamos sus Key_trigger para saber si hace algun match 
             * con el mensaje WSP del usuario
             */
            foreach($Bot->logicResponses as $LoResponse){
                array_push($Keys_arr, $LoResponse->key_trigger);
                $key_str_ar = array($Keys_arr[$count]);
                $match_key = $this->logicResponseToMessage($key_string, $key_str_ar);

                if ($match_key) {
                    Log::info("BotWsp: ¡MATCH con el trigger '{$LoResponse->key_trigger}'! Respuesta: '{$LoResponse->response}'");
                    return $LoResponse->response;
                }

                $count++;
            }
        }

        return null;
    }




}
