<?php

namespace App\Services\AI\Guards;

class MessageSanitizer
{
    protected int $maxLength;

    public function __construct()
    {
        $this->maxLength = (int) config('ai.max_message_chars', 800);
    }

    /**
     * Limpia el mensaje entrante, remueve caracteres peligrosos/invisibles y trunca si excede el límite.
     */
    public function sanitize(string $text): string
    {
        // 1. Eliminar caracteres nulos o secuencias de escape de control
        $cleaned = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $text);

        // 2. Normalizar espacios en blanco repetitivos
        $cleaned = preg_replace('/\s+/u', ' ', $cleaned);
        $cleaned = trim($cleaned);

        // 3. Truncar longitud para evitar abuso de tokens
        if (mb_strlen($cleaned) > $this->maxLength) {
            $cleaned = mb_substr($cleaned, 0, $this->maxLength);
        }

        return $cleaned;
    }

    /**
     * Detecta intentos flagrantes de Prompt Injection / Jailbreak.
     */
    public function containsPromptInjection(string $text): bool
    {
        $suspiciousPatterns = [
            '/ignora\s+(todas\s+las\s+)?instrucciones\s+(anteriores|previas)/i',
            '/ignore\s+(all\s+)?previous\s+instructions/i',
            '/olvida\s+(qui[eé]n\s+eres|tu\s+rol)/i',
            '/revela\s+(tu\s+)?(system\s+prompt|prompt\s+del\s+sistema)/i',
            '/act[uú]a\s+como\s+(un\s+)?dan/i',
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $text)) {
                return true;
            }
        }

        return false;
    }
}
