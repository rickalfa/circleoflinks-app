<?php

namespace App\Providers;


use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use App\Enums\RoleEnum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Super Admin implícito: otorga todas las habilidades al rol ADMIN
        Gate::before(function ($user, string $ability) {
            return method_exists($user, 'hasRole') && $user->hasRole(RoleEnum::ADMIN->value) ? true : null;
        });
    
    // 1. Límite para la API general (ej: 60 peticiones por minuto)
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // 2. Límite estricto para LOGIN (ej: 5 intentos por minuto para evitar fuerza bruta)
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // 3. Límite para registro de usuarios (ej: 3 por hora para evitar bots)
        RateLimiter::for('register', function (Request $request) {
            return Limit::perHour(3)->by($request->ip());
        });


    }
}
