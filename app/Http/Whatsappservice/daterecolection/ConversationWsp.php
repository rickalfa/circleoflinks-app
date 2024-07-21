<?php

namespace App\Http\Whatsappservice\Daterecolection;

use App\Http\Controllers\Controller;
use APp\Http\Whatsappservice\Daterecolection\UserWsp;
use App\Models\Conversation;
use App\Models\UserApp;

class ConversationWsp extends Controller{


    protected $Userwsp;

    public function __construct( $dates){

       
        $data = $dates;
   
        if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
            $phoneUser = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];



            // Convertir el valor a string, aunque deberÃ­a serlo ya
            $phoneAsString = (string) $phoneUser ;
  
            $Userexist = UserApp::where('phone', '=', $phoneAsString)->first();


           print_r($Userexist);

            if(isset($Userexist)){

                echo "el usuario existe  ";
                
                


            }else{

                echo "el usuario NO existe";

                /** si el usuario no existe se crea uno con los nombres desconocidos 
                 * con el status de visita
                 */

                 $usernew = UserApp::create([
                    'name' => "unknow",
                    'phone' => $phoneAsString,
                    'password' => "provisorio",
                    'user_app_status_id' => 2 

                 ]);

                 if(isset($usernew)){

                    echo "Usuario-App creado : </br>";

                    print_r($usernew);

                 }


            }

            // Registrar el valor en el log
        
         
          }
  
        

       



    }

    public function startConversation(){

/**
 * 1_nr
 *  Comprovamos si el usuario es la Primera vez que chatea con nosotros, si esta
 * en la tabla contactos, si no lo creamos con el UserApp y su relacion Contact
 */



      echo "  start Conversation  ";
/**
 * 2_nr
 * identificamos que Bot se utilizara para responder al nuevo contacto
 * se determina la Logica de respuesta
 */


 
  /**
   * 3_nr
   * recolecion de Datos de la conversacion y los integrantes  de la conversacion 
   * y se actualiza la cadena de Mensajes por mensaje enviado y respondido
   * 
   */
        


    }



}