<?php

namespace App\Services\AI;

use App\Services\AI\Contracts\MllServiceInterface;
use App\Services\AI\Drivers\GeminiDriver;
use App\Services\AI\Drivers\OpenAiDriver;
use InvalidArgumentException;

class MllServiceManager
{
    /**
     * Resuelve y retorna el driver adecuado según el proveedor y modelo solicitados.
     *
     * @param string|null $provider 'gemini', 'openai'
     * @param string|null $model
     * @return MllServiceInterface
     */
    public function driver(?string $provider = null, ?string $model = null): MllServiceInterface
    {
        $provider = $provider ?: config('ai.default_provider', 'gemini');

        return match (strtolower(trim($provider))) {
            'gemini'   => new GeminiDriver($model),
            'openai'   => new OpenAiDriver($model),
            default    => throw new InvalidArgumentException("Proveedor de IA no soportado: [{$provider}]. Soportados: 'gemini', 'openai'."),
        };
    }
}
