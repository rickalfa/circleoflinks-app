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


       
        echo " Recepcion de mensaje desde ".__CLASS__;




        $succes_key =  $this->logicResponseToMessage($message, ["pilar"]);

        if ($succes_key) {

            $this->SendMsgWsp->sendMessageWsp("hola como estas un gusto pilar ?", $number_user);

            echo " mensaje enviado desde ".__CLASS__;

          
        }else{

            echo " No se detecto la Key mensaje NO enviado desde ".__CLASS__;


        }
        


    }

    private function logicResponseToMessage($text, $patterns){

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

    private function sendWspMessage(){



    }

    private function selectBotActive(){


        



    }




}
