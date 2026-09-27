<?php

namespace App\Enums;

enum PermissionEnum: string
{
    // Usuarios y Perfiles
    case USERS_VIEW = 'users.view';
    case USERS_CREATE = 'users.create';
    case USERS_EDIT = 'users.edit';
    case USERS_DELETE = 'users.delete';
    case PROFILES_VIEW = 'profiles.view';
    case PROFILES_EDIT = 'profiles.edit';

    // Empresas
    case EMPRESAS_VIEW = 'empresas.view';
    case EMPRESAS_CREATE = 'empresas.create';
    case EMPRESAS_EDIT = 'empresas.edit';
    case EMPRESAS_DELETE = 'empresas.delete';

    // Ofertas Laborales
    case OFERTAS_VIEW = 'ofertas.view';
    case OFERTAS_CREATE = 'ofertas.create';
    case OFERTAS_EDIT = 'ofertas.edit';
    case OFERTAS_DELETE = 'ofertas.delete';

    // Postulaciones
    case POSTULACIONES_VIEW = 'postulaciones.view';
    case POSTULACIONES_CREATE = 'postulaciones.create';
    case POSTULACIONES_EDIT = 'postulaciones.edit';
    case POSTULACIONES_DELETE = 'postulaciones.delete';

    // Proyectos
    case PROYECTOS_VIEW = 'proyectos.view';
    case PROYECTOS_CREATE = 'proyectos.create';
    case PROYECTOS_EDIT = 'proyectos.edit';
    case PROYECTOS_DELETE = 'proyectos.delete';

    // API Tokens
    case TOKENS_VIEW = 'tokens.view';
    case TOKENS_CREATE = 'tokens.create';
    case TOKENS_DELETE = 'tokens.delete';

    // WhatsApp / Chatbot (compatibilidad con rama whatsappservice)
    case WHATSAPP_VIEW = 'whatsapp.view';
    case WHATSAPP_MANAGE = 'whatsapp.manage';
    case LEADS_MANAGE = 'leads.manage';

    // Gestión de Roles y Permisos
    case ROLES_MANAGE = 'roles.manage';
    case PERMISSIONS_MANAGE = 'permissions.manage';

    /**
     * Devuelve todos los permisos como un array de strings.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
