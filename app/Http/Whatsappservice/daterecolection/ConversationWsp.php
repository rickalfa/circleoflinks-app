<?php

namespace App\Http\Whatsappservice\Daterecolection;

use App\Http\Controllers\Controller;
use App\Http\Whatsappservice\Daterecolection\UserWsp;
use App\Http\Whatsappservice\Daterecolection\BotWsp;
use App\Models\Conversation;
use App\Models\UserApp;
use App\Models\userAppContact;

class ConversationWsp extends Controller{


    protected $Userwsp;
    protected $Botwsp;

    /**
     * Summary of __construct
     * @param mixed $dates
     * el Parametro $dates son los datos enviados por la WhatsApp API Cloud
     * son enviados por e usuario cuando envia un Mensaje al numero Configurado para el projecto 
     * que esta utilizando la API de WhatsApp la documentacion oficial
     *  https://developers.facebook.com/docs/whatsapp/cloud-api/guides/send-messages#solicitudes
     */
    public function __construct( $dates){

       
        $data = $dates;
   
        if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
            $phoneUser = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];

            // Convertir el valor a string, aunque deberÃ­a serlo ya
            $phoneAsString = (string) $phoneUser ;
  
             /**
             * 1_nr
             *  Comprovamos si el usuario es la Primera vez que chatea con nosotros, si esta
             * en el Modelo UserAppContact, si no lo creamos con el UserApp y su relacion Contact
             */
            $Userexist = UserAppContact::where('phone_number', '=', $phoneAsString)->first();


           print_r($Userexist);

            if(isset($Userexist)){

                echo "el usuario existe  ";
                

                /**
                 * 2_nr
                 * SI no EXISTE el usuario se 
                 * crea uno nuevo y como contacto y usuario UNKNOW 
                 * con el status "no registrado"
                 */
            }else{

                echo "el usuario NO existe";

                /** si el usuario no existe se crea uno con los nombres desconocidos 
                 * con el status de visita
                 */

                 $usernew = UserApp::create([
                    'name' => "unknow",
                    'password' => "provisorio",
                    'user_app_status_id' => 2 

                 ]);

                 /**
                  * y el usuario como CONTACTO de la App
                  */

                 $usernewcontact = UserAppContact::create(
                    [
                    'user_id'=> $usernew->id,
                    'phone_number'=>  $phoneAsString,
                    'status'=> "no register"

                    ]
                 );

                  /**
                  * usuario como LEAD de la App
                  */

                  

                 if(isset($usernew)){

                    echo "</br> Usuario-App creado : </br>";

                    print_r($usernew);

                 }


            }

          
         
          }
  

               /**
             * Creamos a   $UserWsp con los $dates
             *
             * y $BotWsp segun los que estan activos
             */

             $this->Userwsp = new UserWsp($dates);

             $this->Botwsp = new BotWsp();



       



    }

    public function startConversation(){

        echo "  start Conversation from ".__CLASS__;
/**
 * 1_nr
 *  
 * recivimos el mensaje de WSP del UserWsp y su numero de celular 
 */

     $user_msg_wsp = $this->Userwsp->getMessage();
     $user_phone_wsp = $this->Userwsp->getPhone();
 

/**
 * 2_nr
 * le entregamos el mensaje y el numero de quien iso el mensaje al BotWsp
 * identificamos que BotWsp se utilizara para responder al nuevo contacto
 * se determina la Logica de respuesta 
 */

     $this->Botwsp->receptionMessage($user_msg_wsp, $user_phone_wsp);


     $this->Botwsp->sendWspMessage();
     
    
 
  /**
   * 3_nr
   * recolecion de Datos de la conversacion y los integrantes  de la conversacion 
   * y se actualiza la cadena de Mensajes por mensaje enviado y respondido
   * 
   */
        


    }



}