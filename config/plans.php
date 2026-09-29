<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Business Plans and Limits
    |--------------------------------------------------------------------------
    |
    | Here you can configure the limits for each subscription plan.
    | A limit of -1 means "unlimited".
    |
    */

    'free' => [
        'max_projects' => 1,
        'max_bots' => 100, // Lógica de respuestas
        'max_leads' => 60, // Límite mensual de conversaciones únicas
        'proactive_messaging' => false, // No templates allowed
        'custom_phone' => false,
    ],
    
    'premium' => [
        'max_projects' => -1, // Ilimitado
        'max_bots' => -1,
        'max_leads' => -1,
        'proactive_messaging' => true,
        'custom_phone' => true,
    ],
];
