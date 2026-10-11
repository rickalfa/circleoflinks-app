<?php

namespace App\Services\AI\DTOs;

class LlmResponse
{
    public function __construct(
        public string $text,
        public int $promptTokens,
        public int $completionTokens,
        public int $totalTokens,
        public float $costUsd,
        public string $provider,
        public string $model,
        public bool $handover = false,
        public ?string $intent = null,
        public ?array $rawPayload = null
    ) {}

    public function isHandoverRequested(): bool
    {
        return $this->handover;
    }
}
