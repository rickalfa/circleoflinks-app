<?php

namespace App\Services\WhatsappApi;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\userAppContact;
use App\Models\WhatsappApi\Conversation;
use App\Models\WhatsappApi\Lead;

class ConversationWsp extends Controller{


    protected $Userwsp;
    protected $Botwsp;
    protected $currentUserId;

    public function __construct($dates)
    {
        $data = $dates;
    
        if (isset($data['entry'][0]['changes'][0]['value']['messages'][0]['from'])) {
            $phoneUser = $data['entry'][0]['changes'][0]['value']['messages'][0]['from'];
            $phoneAsString = (string) $phoneUser;

            // Extraer nombre de perfil y avatar del webhook de Meta
            $profileService = new WhatsAppProfileService();
            $profileData = $profileService->extractProfileFromWebhook($data, $phoneAsString);

            $leadName      = $profileData['name'] ?? 'Lead WhatsApp';
            $leadAvatarUrl = $profileData['avatar_url'];
  
            $Userexist = UserAppContact::where('phone_number', '=', $phoneAsString)->first();

            if(isset($Userexist)){
                $this->currentUserId = $Userexist->user_id;

                // Actualizar Lead: si ya tiene avatar guardado, no sobreescribir con null
                $existingLead = Lead::where('user_id', $Userexist->user_id)->first();
                Lead::updateOrCreate(
                    ['user_id' => $Userexist->user_id],
                    [
                        'name'              => $leadName,
                        'phone_number'      => $phoneAsString,
                        'last_message_time' => now(),
                        'state'             => 'active',
                        'has_unread_messages' => true,
                        'avatar_url'        => $leadAvatarUrl ?? ($existingLead->avatar_url ?? null),
                    ]
                );
            }else{
                 $usernew = UserApp::create([
                    'name'               => $leadName,
                    'password'           => "provisorio",
                    'user_app_status_id' => 2,
                    'email'              => $phoneAsString . "@whatsapp.local"
                 ]);
                 $this->currentUserId = $usernew->id;

                 UserAppContact::create([
                    'user_id'      => $usernew->id,
                    'phone_number' => $phoneAsString,
                    'status'       => "no register"
                 ]);

                 Lead::updateOrCreate(
                     ['user_id' => $usernew->id],
                     [
                         'name'              => $leadName,
                         'phone_number'      => $phoneAsString,
                         'last_message_time' => now(),
                         'state'             => 'active',
                         'has_unread_messages' => true,
                         'avatar_url'        => $leadAvatarUrl,
                     ]
                 );
            }
        }

        $this->Userwsp = new UserWsp($dates);
        $this->Botwsp = new BotWsp();
    }


    public function startConversation()
    {
        // Si no hay un UserApp asociado (por ejemplo, es un webhook de confirmación de lectura de Meta)
        // abortamos porque no hay conversación que procesar
        if (!$this->currentUserId) {
            \Illuminate\Support\Facades\Log::info("ConversationWsp: Webhook ignorado (no es un mensaje entrante o no hay usuario).");
            return;
        }

        $user_msg_wsp = $this->Userwsp->getMessage();
        $user_phone_wsp = $this->Userwsp->getPhone();

        // 1. Obtener o crear la Conversación Activa
        // Por defecto, se asocia al bot principal (agente id 1) si es nueva
        $conversation = Conversation::firstOrCreate(
            ['user_id' => $this->currentUserId],
            [
                'agent_id' => 1, 
                'status' => 'bot_active',
                'type' => 'user',
                'message' => 'Chat iniciado' // Evita error SQL porque la columna message no es nullable
            ]
        );

        // 2. Guardar el Mensaje Entrante
        if ($user_msg_wsp) {
            \App\Models\WhatsappApi\Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $this->currentUserId,
                'sender_type' => 'user',
                'content' => $user_msg_wsp,
                'sent_at' => now(),
            ]);
        }

        // 3. Evaluar el Estado (HANDOVER PATTERN)
        // Si el estado es 'human_active', el bot se silencia y no responde.
        if ($conversation->status === 'bot_active') {
            // El bot toma el control
            $this->Botwsp->receptionMessage($user_msg_wsp, $user_phone_wsp);
            $botResponse = $this->Botwsp->getLogicResponse(); // Obtenemos la respuesta calculada
            
            $this->Botwsp->sendWspMessage();
            
            // Guardamos el mensaje saliente del Bot en la base de datos
            if ($botResponse) {
                \App\Models\WhatsappApi\Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => 1, // ID del bot por defecto
                    'sender_type' => 'agent',
                    'content' => $botResponse,
                    'sent_at' => now(),
                ]);
            }
        } else {
            // Está en 'human_active'. No hacemos nada automático.
            // El mensaje ya quedó guardado en la BD y el operador lo verá en su panel Vue.
            \Illuminate\Support\Facades\Log::info("Chat en modo humano. Bot silenciado para el user_id: " . $this->currentUserId);
        }
    }
}
