<?php

namespace App\Http\Controllers\WhatsappApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     * @return string
     */
    public function sendMessageWsp($mensaje, $numberTo): string{
        if (!is_string($mensaje) || empty(trim($mensaje))) {
            return "";
        }

        $phoneId = env('WHATSSAP_PHONE_NUMBER_ID', '1281361591727608');
        $token = env('WHATSSAP_API_TOKEN');

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $numberTo,
            'type' => 'text',
            'text' => [
                'body' => $mensaje,
            ],
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.facebook.com/v19.0/{$phoneId}/messages",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            Log::error('Error enviando mensaje WhatsApp cURL: ' . $err);
        } else {
            Log::info('Respuesta de Meta al enviar mensaje: ' . $response);
        }

        return $response ?: "";
    }
}
