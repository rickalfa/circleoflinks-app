<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case RECLUTADOR = 'reclutador';
    case CANDIDATO = 'candidato';
    case USER = 'user';

    /**
     * Devuelve todos los valores de los roles como un array de strings.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
