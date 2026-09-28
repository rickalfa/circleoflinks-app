<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\RoleEnum;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Usuario Administrador / Super-Admin de desarrollo
        $admin = User::firstOrCreate(
            ['email' => 'admin@circleoflinks.com'],
            [
                'name' => 'Admin CircleOfLinks',
                'password' => 'password',
                'address' => 'Central Office',
                'status_user_id' => 1,
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles([RoleEnum::ADMIN->value]);

        // 2. Usuario Reclutador / Empresa
        $reclutador = User::firstOrCreate(
            ['email' => 'reclutador@circleoflinks.com'],
            [
                'name' => 'Reclutador CircleOfLinks',
                'password' => 'password',
                'address' => 'Empresa Hub',
                'status_user_id' => 1,
                'email_verified_at' => now(),
            ]
        );
        $reclutador->syncRoles([RoleEnum::RECLUTADOR->value]);

        // 3. Usuario Candidato / Postulante
        $candidato = User::firstOrCreate(
            ['email' => 'candidato@circleoflinks.com'],
            [
                'name' => 'Candidato Demo',
                'password' => 'password',
                'address' => 'Remote',
                'status_user_id' => 1,
                'email_verified_at' => now(),
            ]
        );
        $candidato->syncRoles([RoleEnum::CANDIDATO->value]);

        // 4. Usuarios aleatorios de prueba asignados como candidatos
        $users = User::factory(10)->create();
        foreach ($users as $user) {
            $user->assignRole(RoleEnum::CANDIDATO->value);
        }
    }
}
