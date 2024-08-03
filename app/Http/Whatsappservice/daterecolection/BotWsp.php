<?php

namespace App\Http\Whatsappservice\Daterecolection;

use App\Models\Agent;
use App\Http\Controllers\WhatsappApi\WspbController;
use App\Http\Controllers\WhatsappApi\WspSendMessageController;
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


       
        echo "</br> Recepcion de mensaje desde ".__CLASS__;

        echo $message;

        /**
         * buscamos todas las key_Trigger de los bots Activados
         */
        $this->logic_response = $this->selectResponsesFromBotActive($message);


        $this->num_phone = $number_user;

        $respuesta = $this->logic_response;

        echo " </br> <br> respuesta del Bot : ";

        print_r($respuesta);



    }
    
    public function sendWspMessage(){
 
        $respuesta_bot = $this->SendMsgWsp->sendMessageWsp($this->logic_response, $this->num_phone);


        echo $respuesta_bot;

    }


    private function logicResponseToMessage($text, $patterns): bool{

                // Escapar caracteres especiales del patrón para uso en expresión regular
                $escapedPatterns = array_map(function($pattern) {
                    return preg_quote($pattern, '/');
                }, $patterns);
            
         // Crear una expresión regular que busque cualquiera de los patrones
            $regex = '/(' . implode('|', $escapedPatterns) . ')/';

            // Usar preg_match para verificar si el patrón existe en el texto
            if (preg_match($regex, $text)) {


                return true;
            } else {

                return false;
            }




    }

    private function selectResponsesFromBotActive($key_string)
    {


        $BotsActives = Agent::where('status', 'active')->get();


        $Keys_arr = array();

        $count = 0;

        /**
         * recorrimos el arreglo de Bots que estan con status = 'active'
         * 
         */
        foreach($BotsActives as $Bot){

          

            /**
             * recorrimos el areglo de Logicresponses que contiene el Bot
             * y comparamos sus Key_trigger para saber si hace algun match 
             * con el mensaje WSP del usuario
             */
            foreach($Bot->logicResponses as $LoResponse){

               
                array_push($Keys_arr, $LoResponse->key_trigger);

                $key_str_ar = array($Keys_arr[$count]);

                $match_key = $this->logicResponseToMessage($key_string, $key_str_ar);


                if ($match_key) {
                    
                    echo "match encontrado de las keys : ";
                    print($Keys_arr[$count]);

                    return $LoResponse->response;

    
                }else{
    
                    echo " NO hiso match de las keys : ";
                    print_r($Keys_arr);
    
    
                }
    
                $count++;

            }
           

           echo '<br> Bots dentro de FOREACH :</br>';
           print_r($Keys_arr);

       
          

        }

        return $Keys_arr;
       
    }




}
