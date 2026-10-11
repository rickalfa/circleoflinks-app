<?php

namespace App\Services\AI\Drivers;

use App\Services\AI\Contracts\MllServiceInterface;
use App\Services\AI\DTOs\LlmResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAiDriver implements MllServiceInterface
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl;
    protected array $rates;

    public function __construct(?string $model = null)
    {
        $config = config('ai.providers.openai');
        $this->apiKey  = (string) ($config['api_key'] ?? '');
        $this->model   = $model ?: ($config['model'] ?? 'gpt-4o-mini');
        $this->baseUrl = $config['base_url'] ?? 'https://api.openai.com/v1';
        $this->rates   = $config['rates'] ?? ['input_per_million' => 0.15, 'output_per_million' => 0.60];
    }

    public function getProviderName(): string
    {
        return 'openai';
    }

    public function getModelName(): string
    {
        return $this->model;
    }

    public function chat(array $messages, array $options = []): LlmResponse
    {
        if (empty($this->apiKey)) {
            throw new Exception("API Key de OpenAI no configurada en .env (OPENAI_API_KEY o AI_API_KEY).");
        }

        $formattedMessages = array_map(function ($msg) {
            return is_array($msg) ? $msg : ['role' => $msg->role, 'content' => $msg->content];
        }, $messages);

        $temperature = $options['temperature'] ?? 0.70;
        $maxTokens   = $options['max_tokens'] ?? 400;

        $endpoint = rtrim($this->baseUrl, '/') . '/chat/completions';

        Log::info("OpenAiDriver: Enviando solicitud a {$endpoint} con modelo {$this->model}");

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->timeout(20)->post($endpoint, [
            'model'       => $this->model,
            'messages'    => $formattedMessages,
            'temperature' => (float) $temperature,
            'max_tokens'  => (int) $maxTokens,
        ]);

        if ($response->failed()) {
            Log::error("OpenAiDriver Error: " . $response->body());
            throw new Exception("Error al comunicar con OpenAI API: " . $response->status() . " " . $response->body());
        }

        $data = $response->json();

        $contentRaw = $data['choices'][0]['message']['content'] ?? '';
        $promptTokens = (int) ($data['usage']['prompt_tokens'] ?? 0);
        $completionTokens = (int) ($data['usage']['completion_tokens'] ?? 0);
        $totalTokens = (int) ($data['usage']['total_tokens'] ?? ($promptTokens + $completionTokens));

        $costInput = ($promptTokens / 1000000) * ($this->rates['input_per_million'] ?? 0.15);
        $costOutput = ($completionTokens / 1000000) * ($this->rates['output_per_million'] ?? 0.60);
        $totalCost = round($costInput + $costOutput, 6);

        $handover = false;
        $cleanText = trim($contentRaw);
        $intent = null;

        if (str_starts_with($cleanText, '{') && str_ends_with($cleanText, '}')) {
            $parsed = json_decode($cleanText, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($parsed['reply'])) {
                $cleanText = (string) $parsed['reply'];
                $handover  = (bool) ($parsed['handover'] ?? false);
                $intent    = $parsed['intent'] ?? null;
            }
        }

        return new LlmResponse(
            text: $cleanText,
            promptTokens: $promptTokens,
            completionTokens: $completionTokens,
            totalTokens: $totalTokens,
            costUsd: $totalCost,
            provider: $this->getProviderName(),
            model: $this->getModelName(),
            handover: $handover,
            intent: $intent,
            rawPayload: $data
        );
    }
}
