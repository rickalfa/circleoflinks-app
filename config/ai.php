<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Proveedor de IA Predeterminado
    |--------------------------------------------------------------------------
    | Define el proveedor que se usará si un agente no especifica uno.
    | Opciones soportadas: 'gemini', 'openai'
    */
    'default_provider' => env('AI_DEFAULT_PROVIDER', 'gemini'),

    /*
    |--------------------------------------------------------------------------
    | Tiempos y Límites de Seguridad
    |--------------------------------------------------------------------------
    */
    'debounce_seconds'      => env('AI_DEBOUNCE_SECONDS', 5),      // Espera para agrupar mensajes
    'daily_limit_per_lead'  => env('AI_DAILY_LIMIT_PER_LEAD', 25), // Tope diario de respuestas IA por lead
    'max_message_chars'     => 800,                                // Máx caracteres procesados por mensaje
    'history_message_limit' => 8,                                  // Últimos mensajes enviados a la IA

    /*
    |--------------------------------------------------------------------------
    | Configuración de Proveedores y Tarifas de Tokens (USD por 1M de tokens)
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'gemini' => [
            'api_key'  => env('GEMINI_API_KEY', env('AI_API_KEY')),
            'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
            'model'    => env('GEMINI_DEFAULT_MODEL', 'gemini-3.5-flash-lite'),
            // Tarifas de referencia para cálculo en ai_usage_logs (USD / 1M tokens)
            'rates'    => [
                'input_per_million'  => 0.10,
                'output_per_million' => 0.40,
            ],
        ],

        'openai' => [
            'api_key'  => env('OPENAI_API_KEY', env('AI_API_KEY')),
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
            'model'    => env('OPENAI_DEFAULT_MODEL', 'gpt-4o-mini'),
            'rates'    => [
                'input_per_million'  => 0.15,
                'output_per_million' => 0.60,
            ],
        ],
    ],

];
