<?php

namespace App\Http\Whatsappservice\Daterecolection;

use App\Models\UserApp;
use App\Http\Controllers\Controller;
use Exception;



Class UserWsp extends Controller{


    private $numb_phone; 
    private $message;


    public function __constructor($dates){

        $data = $dates;
        if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
            $messageBody = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];
  
            // Convertir el valor a string, aunque deberÃ­a serlo ya
            $phoneAsString = (string) $messageBody;
  
            // Registrar el valor en el log
        
         
          }

        $this->message = $dates->message;

        $this->numb_phone = $dates->numb_phone;



     }


    public function getMenssage(){

        return $this->message;

    }

    public function getPhone(){

        return $this->numb_phone;

    }

    public function receptionMenssage(string $message){


    }







}
