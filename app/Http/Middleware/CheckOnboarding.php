<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOnboarding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si no está autenticado, que siga su curso (otros middlewares se encargarán)
        if (!$user) {
            return $next($request);
        }

        // Si no ha completado el onboarding, redirigir al setup
        if (!$user->onboarding_completed) {
            // Evitar loop infinito si ya está en la ruta de onboarding
            if (!$request->is('onboarding*')) {
                return redirect()->route('onboarding.setup');
            }
        }

        return $next($request);
    }
}
