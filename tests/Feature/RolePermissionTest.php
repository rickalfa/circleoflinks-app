<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;
use Database\Seeders\Status_userSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\UserSeeder;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(Status_userSeeder::class);
        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_roles_and_permissions_are_seeded_correctly(): void
    {
        $this->assertDatabaseHas('roles', ['name' => RoleEnum::ADMIN->value]);
        $this->assertDatabaseHas('roles', ['name' => RoleEnum::RECLUTADOR->value]);
        $this->assertDatabaseHas('roles', ['name' => RoleEnum::CANDIDATO->value]);
        $this->assertDatabaseHas('roles', ['name' => RoleEnum::USER->value]);

        $this->assertDatabaseHas('permissions', ['name' => PermissionEnum::OFERTAS_CREATE->value]);
        $this->assertDatabaseHas('permissions', ['name' => PermissionEnum::WHATSAPP_VIEW->value]);
    }

    public function test_user_seeder_creates_users_with_roles(): void
    {
        $this->seed(UserSeeder::class);

        $admin = User::where('email', 'admin@circleoflinks.com')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->hasRole(RoleEnum::ADMIN->value));
        $this->assertTrue($admin->can(PermissionEnum::OFERTAS_CREATE->value));
        $this->assertTrue($admin->can(PermissionEnum::ROLES_MANAGE->value));

        $reclutador = User::where('email', 'reclutador@circleoflinks.com')->first();
        $this->assertNotNull($reclutador);
        $this->assertTrue($reclutador->hasRole(RoleEnum::RECLUTADOR->value));
        $this->assertTrue($reclutador->hasPermissionTo(PermissionEnum::OFERTAS_CREATE->value));
        $this->assertFalse($reclutador->hasPermissionTo(PermissionEnum::ROLES_MANAGE->value));

        $candidato = User::where('email', 'candidato@circleoflinks.com')->first();
        $this->assertNotNull($candidato);
        $this->assertTrue($candidato->hasRole(RoleEnum::CANDIDATO->value));
        $this->assertTrue($candidato->hasPermissionTo(PermissionEnum::POSTULACIONES_CREATE->value));
        $this->assertFalse($candidato->hasPermissionTo(PermissionEnum::OFERTAS_CREATE->value));
    }

    public function test_super_admin_gate_bypass(): void
    {
        $this->seed(UserSeeder::class);

        $admin = User::where('email', 'admin@circleoflinks.com')->first();
        // Super admin tiene acceso a cualquier habilidad via Gate::before
        $this->assertTrue($admin->can('any-custom-permission-not-in-db'));
    }

    public function test_role_middleware_authorizes_correctly(): void
    {
        $this->seed(UserSeeder::class);

        \Illuminate\Support\Facades\Route::get('/test-role-admin', function () {
            return response()->json(['status' => 'ok']);
        })->middleware(['auth:sanctum', 'role:admin']);

        $admin = User::where('email', 'admin@circleoflinks.com')->first();
        $candidato = User::where('email', 'candidato@circleoflinks.com')->first();

        // Admin puede acceder
        $this->actingAs($admin, 'sanctum')
            ->getJson('/test-role-admin')
            ->assertStatus(200);

        // Candidato recibe 403 Forbidden
        $this->actingAs($candidato, 'sanctum')
            ->getJson('/test-role-admin')
            ->assertStatus(403);
    }

    public function test_permission_middleware_authorizes_correctly(): void
    {
        $this->seed(UserSeeder::class);

        \Illuminate\Support\Facades\Route::get('/test-permission-ofertas', function () {
            return response()->json(['status' => 'ok']);
        })->middleware(['auth:sanctum', 'permission:ofertas.create']);

        $reclutador = User::where('email', 'reclutador@circleoflinks.com')->first();
        $candidato = User::where('email', 'candidato@circleoflinks.com')->first();

        // Reclutador tiene ofertas.create
        $this->actingAs($reclutador, 'sanctum')
            ->getJson('/test-permission-ofertas')
            ->assertStatus(200);

        // Candidato no tiene ofertas.create -> 403 Forbidden
        $this->actingAs($candidato, 'sanctum')
            ->getJson('/test-permission-ofertas')
            ->assertStatus(403);
    }
}

