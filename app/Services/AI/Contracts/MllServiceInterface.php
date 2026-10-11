<?php

namespace App\Services\AI\Contracts;

use App\Services\AI\DTOs\LlmResponse;

interface MllServiceInterface
{
    /**
     * Envía una lista de mensajes al modelo de lenguaje y retorna la respuesta estandarizada.
     *
     * @param array $messages Lista de objetos LlmMessage o arreglos ['role' => ..., 'content' => ...]
     * @param array $options Opciones como temperature, max_tokens, etc.
     * @return LlmResponse
     */
    public function chat(array $messages, array $options = []): LlmResponse;

    /**
     * Retorna el identificador del proveedor (ej. 'gemini', 'openai').
     */
    public function getProviderName(): string;

    /**
     * Retorna el nombre del modelo activo en el driver.
     */
    public function getModelName(): string;
}
