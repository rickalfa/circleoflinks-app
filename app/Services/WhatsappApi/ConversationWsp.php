<?php

namespace App\Services\WhatsappApi;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\userAppContact;
use App\Models\WhatsappApi\Conversation;
use App\Models\WhatsappApi\Lead;
use App\Models\Project;

class ConversationWsp extends Controller{


    protected $Userwsp;
    protected $Botwsp;
    protected $currentUserId;
    protected $currentProjectId; // Nuevo: El ID del proyecto (bot)

    public function __construct($dates)
    {
        $data = $dates;
    
        // 1. Identificar el Bot/Proyecto receptor
        $this->currentProjectId = null;
        if (isset($data['entry'][0]['changes'][0]['value']['metadata']['display_phone_number'])) {
            $botNumber = $data['entry'][0]['changes'][0]['value']['metadata']['display_phone_number'];
            $project = Project::where('phone_number', $botNumber)->first();
            if ($project) {
                $this->currentProjectId = $project->id;
            }
        }

        // 2. Procesar el remitente (Lead)
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

                // Actualizar Lead existente (inyectando project_id por si no lo tenía)
                $existingLead = Lead::where('user_id', $Userexist->user_id)->first();
                $newCount = ($existingLead->unread_messages_count ?? 0) + 1;
                Lead::updateOrCreate(
                    ['user_id' => $Userexist->user_id],
                    [
                        'project_id'        => $this->currentProjectId,
                        'name'              => $leadName,
                        'phone_number'      => $phoneAsString,
                        'last_message_time' => now(),
                        'state'             => 'active',
                        'has_unread_messages' => true,
                        'unread_messages_count' => $newCount,
                        'avatar_url'        => $leadAvatarUrl ?? ($existingLead->avatar_url ?? null),
                    ]
                );
            }else{
                 // Crear nuevo usuario amarrado al proyecto actual
                 $usernew = UserApp::create([
                    'project_id'         => $this->currentProjectId,
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

                 // Crear nuevo Lead amarrado al proyecto actual
                 Lead::updateOrCreate(
                     ['user_id' => $usernew->id],
                     [
                         'project_id'        => $this->currentProjectId,
                         'name'              => $leadName,
                         'phone_number'      => $phoneAsString,
                         'last_message_time' => now(),
                         'state'             => 'active',
                         'has_unread_messages' => true,
                         'unread_messages_count' => 1,
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
        if (!$this->currentUserId) {
            \Illuminate\Support\Facades\Log::info("ConversationWsp: Webhook ignorado (no es un mensaje entrante o no hay usuario).");
            return;
        }

        $user_msg_wsp = $this->Userwsp->getMessage();
        $user_phone_wsp = $this->Userwsp->getPhone();

        // 1. Obtener o crear la Conversación Activa amarrada al proyecto
        $conversation = Conversation::firstOrCreate(
            ['user_id' => $this->currentUserId],
            [
                'project_id' => $this->currentProjectId, // Aislamiento multi-tenant
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
        if ($conversation->status === 'bot_active') {
            // El bot toma el control
            $this->Botwsp->receptionMessage($user_msg_wsp, $user_phone_wsp);
            $botResponse = $this->Botwsp->getLogicResponse(); 
            
            $this->Botwsp->sendWspMessage();
            
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
            \Illuminate\Support\Facades\Log::info("Chat en modo humano. Bot silenciado para el user_id: " . $this->currentUserId);
        }
    }
}
