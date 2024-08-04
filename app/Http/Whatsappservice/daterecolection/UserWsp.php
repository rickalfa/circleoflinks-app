<?php

namespace App\Http\Whatsappservice\Daterecolection;

use App\Models\UserApp;

use App\Http\Controllers\Controller;

use Exception;



Class UserWsp extends Controller{


    private $numb_phone; 
    private $message;

    


    public function __construct($dates){

        $data = $dates;
        if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
            $phoneBody = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];
  
            // Convertir el valor a string, aunque deberÃ­a serlo ya
            $phoneAsString = (string) $phoneBody;
  
            // Registrar el valor en el log
        
         
          }

          if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['text'])) {

            
            $messageBody = $data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
  
            // Convertir el valor a string, aunque deberÃ­a serlo ya
            $messageAsString = (string) $messageBody;
  
            // Registrar el valor en el log
        
         
          }


        $this->message = $messageAsString;

        $this->numb_phone = $phoneAsString;



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
