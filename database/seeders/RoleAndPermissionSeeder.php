<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar la caché de permisos y roles en Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Crear todos los permisos definidos en PermissionEnum
        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate([
                'name' => $permission->value,
                'guard_name' => 'web',
            ]);
        }

        // 2. Crear y configurar roles
        // Rol: Super-Admin / Admin (Tiene acceso a todos los permisos)
        $adminRole = Role::firstOrCreate([
            'name' => RoleEnum::ADMIN->value,
            'guard_name' => 'web',
        ]);
        $adminRole->syncPermissions(Permission::all());

        // Rol: Reclutador / Empresa
        $reclutadorRole = Role::firstOrCreate([
            'name' => RoleEnum::RECLUTADOR->value,
            'guard_name' => 'web',
        ]);
        $reclutadorRole->syncPermissions([
            PermissionEnum::EMPRESAS_VIEW->value,
            PermissionEnum::EMPRESAS_EDIT->value,
            PermissionEnum::OFERTAS_VIEW->value,
            PermissionEnum::OFERTAS_CREATE->value,
            PermissionEnum::OFERTAS_EDIT->value,
            PermissionEnum::OFERTAS_DELETE->value,
            PermissionEnum::POSTULACIONES_VIEW->value,
            PermissionEnum::POSTULACIONES_EDIT->value,
            PermissionEnum::PROYECTOS_VIEW->value,
            PermissionEnum::WHATSAPP_VIEW->value,
            PermissionEnum::WHATSAPP_MANAGE->value,
            PermissionEnum::LEADS_MANAGE->value,
            PermissionEnum::PROFILES_VIEW->value,
            PermissionEnum::PROFILES_EDIT->value,
            PermissionEnum::TOKENS_VIEW->value,
            PermissionEnum::TOKENS_CREATE->value,
            PermissionEnum::TOKENS_DELETE->value,
        ]);

        // Rol: Candidato / Postulante
        $candidatoRole = Role::firstOrCreate([
            'name' => RoleEnum::CANDIDATO->value,
            'guard_name' => 'web',
        ]);
        $candidatoRole->syncPermissions([
            PermissionEnum::OFERTAS_VIEW->value,
            PermissionEnum::POSTULACIONES_VIEW->value,
            PermissionEnum::POSTULACIONES_CREATE->value,
            PermissionEnum::PROYECTOS_VIEW->value,
            PermissionEnum::PROYECTOS_CREATE->value,
            PermissionEnum::PROYECTOS_EDIT->value,
            PermissionEnum::PROYECTOS_DELETE->value,
            PermissionEnum::PROFILES_VIEW->value,
            PermissionEnum::PROFILES_EDIT->value,
            PermissionEnum::TOKENS_VIEW->value,
            PermissionEnum::TOKENS_CREATE->value,
        ]);

        // Rol: Usuario estándar (User)
        $userRole = Role::firstOrCreate([
            'name' => RoleEnum::USER->value,
            'guard_name' => 'web',
        ]);
        $userRole->syncPermissions([
            PermissionEnum::OFERTAS_VIEW->value,
            PermissionEnum::PROFILES_VIEW->value,
            PermissionEnum::PROFILES_EDIT->value,
        ]);
    }
}
