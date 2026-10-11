<?php

namespace App\Services\AI\DTOs;

class LlmMessage
{
    public function __construct(
        public string $role,    // 'system', 'user', 'assistant'
        public string $content  // Texto del mensaje
    ) {}

    public static function system(string $content): self
    {
        return new self('system', $content);
    }

    public static function user(string $content): self
    {
        return new self('user', $content);
    }

    public static function assistant(string $content): self
    {
        return new self('assistant', $content);
    }

    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'content' => $this->content,
        ];
    }
}
