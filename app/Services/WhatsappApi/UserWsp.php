<?php

namespace App\Services\WhatsappApi;

use App\Models\UserApp;

use Exception;


Class UserWsp {


    private $numb_phone; 
    private $message;

    

    public function __construct($dates){

        $data = $dates;
        if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
            $phoneBody = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];
  
            // Convertir el valor a string, aunque debería serlo ya
            $phoneAsString = (string) $phoneBody;
  
          }

          if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['text'])) {

            
            $messageBody = $data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
  
            // Convertir el valor a string, aunque debería serlo ya
            $messageAsString = (string) $messageBody;
  
          }


        $this->message = $messageAsString ?? null;

        $this->numb_phone = $phoneAsString ?? null;



     }


    public function getMessage(){

        return $this->message;

    }

    public function getPhone(){

        return $this->numb_phone;

    }

    public function receptionMessage(string $message){




    }

    private function sendMessage(){


    }



}
