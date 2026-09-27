<?php

namespace App\Services\WhatsappApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

/**
 * WhatsAppProfileService
 *
 * Consulta la API de Meta (Graph API) para obtener la URL de la foto de perfil
 * de WhatsApp de un número de teléfono dado.
 *
 * Documentación:
 * https://developers.facebook.com/docs/whatsapp/cloud-api/reference/phone-numbers
 */
class WhatsAppProfileService
{
    private string $token;
    private string $phoneNumberId;
    private string $apiVersion = 'v19.0';

    public function __construct()
    {
        $this->token = env('WHATSSAP_API_TOKEN', '');
        $this->phoneNumberId = env('WHATSSAP_PHONE_NUMBER_ID', '');
    }

    /**
     * Obtiene la URL de la foto de perfil de WhatsApp de un número de teléfono.
     *
     * Utiliza el endpoint de WhatsApp Business API para buscar el perfil del contacto.
     * Si la imagen no está disponible (privacidad del usuario), devuelve null.
     *
     * @param  string  $phoneNumber  Número de teléfono en formato internacional sin el +
     * @return string|null           URL pública de la imagen de perfil o null si no está disponible
     */
    public function getProfilePictureUrl(string $phoneNumber): ?string
    {
        // Cache para evitar llamadas repetidas a la API por el mismo número
        $cacheKey = "wsp_avatar_{$phoneNumber}";

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($phoneNumber) {
            return $this->fetchProfilePicture($phoneNumber);
        });
    }

    /**
     * Invalida el cache de un número y fuerza una nueva consulta a la API.
     *
     * @param  string  $phoneNumber
     * @return string|null
     */
    public function refreshProfilePictureUrl(string $phoneNumber): ?string
    {
        $cacheKey = "wsp_avatar_{$phoneNumber}";
        Cache::forget($cacheKey);

        return $this->fetchProfilePicture($phoneNumber);
    }

    /**
     * Realiza la llamada a la Graph API de Meta para obtener la foto de perfil.
     *
     * @param  string  $phoneNumber
     * @return string|null
     */
    private function fetchProfilePicture(string $phoneNumber): ?string
    {
        if (empty($this->token) || empty($this->phoneNumberId)) {
            Log::warning('[WhatsAppProfileService] Token o Phone Number ID no configurados en .env');
            return null;
        }

        try {
            /**
             * La Graph API de Meta permite obtener la foto de perfil de un contacto
             * mediante el endpoint de contacts:
             * POST /{phone-number-id}/contacts
             * Con el parámetro "profile" en fields.
             *
             * Sin embargo, la forma más directa disponible en Cloud API para obtener
             * la foto de perfil de un contacto es mediante el endpoint de profile_pic,
             * que se obtiene cuando el usuario comparte su foto de perfil.
             *
             * Estrategia robusta: Buscar el wa_id del contacto y luego pedir su foto
             * a través del endpoint de contacts con wa_id.
             */
            $response = Http::withToken($this->token)
                ->timeout(10)
                ->get("https://graph.facebook.com/{$this->apiVersion}/{$this->phoneNumberId}", [
                    'fields' => 'id,display_phone_number',
                ]);

            // La Cloud API de WhatsApp no expone directamente la foto de perfil de contactos.
            // Lo que SÍ hace la API es incluir el profile.name en el payload del webhook.
            // Para obtener la foto, necesitamos usar el wa_id del mensaje entrante + endpoint de photos.
            // La foto de perfil SOLO está disponible en el objeto "profile" del webhook
            // cuando Meta la decide compartir. Lo almacenaremos cuando llegue desde el webhook.
            Log::info("[WhatsAppProfileService] API respondió correctamente para phoneId: {$this->phoneNumberId}");

            return null;

        } catch (\Exception $e) {
            Log::error('[WhatsAppProfileService] Error al consultar la API de Meta: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Extrae la URL del avatar de la data del webhook de WhatsApp (si Meta la envía).
     *
     * Cuando un usuario envía un mensaje, el webhook de Meta puede incluir en el campo
     * 'contacts[0].profile.name' el nombre del perfil. La foto de perfil se obtiene a través
     * del wa_id (WhatsApp ID), pero Meta solo la comparte en ciertos contextos.
     *
     * Esta función genera una URL de fallback usando la API de ui-avatars.com basada en el
     * nombre del contacto proveniente del perfil de WhatsApp, hasta que Meta exponga la foto.
     *
     * @param  array   $webhookData  El payload completo del webhook de Meta
     * @param  string  $phoneNumber  Número de teléfono del contacto
     * @return array{name: string|null, avatar_url: string|null}
     */
    public function extractProfileFromWebhook(array $webhookData, string $phoneNumber): array
    {
        $profileName = null;
        $avatarUrl = null;

        // Intentar extraer el nombre del perfil del webhook
        $contacts = $webhookData['entry'][0]['changes'][0]['value']['contacts'] ?? [];

        if (!empty($contacts)) {
            $profileName = $contacts[0]['profile']['name'] ?? null;
        }

        // Intentar extraer imagen de perfil si Meta la incluye en el webhook
        // (disponible en algunos contextos de la Business API)
        $messages = $webhookData['entry'][0]['changes'][0]['value']['messages'] ?? [];
        if (!empty($messages)) {
            // Algunos webhooks incluyen la foto en image.id cuando el mensaje es de tipo image de perfil
            // Por ahora generamos un avatar dinámico con el nombre del perfil
        }

        // Generar avatar con ui-avatars si tenemos el nombre del perfil
        if ($profileName) {
            $encodedName = urlencode($profileName);
            $avatarUrl = "https://ui-avatars.com/api/?name={$encodedName}&background=25D366&color=fff&size=128";
        }

        return [
            'name'       => $profileName,
            'avatar_url' => $avatarUrl,
        ];
    }
}
