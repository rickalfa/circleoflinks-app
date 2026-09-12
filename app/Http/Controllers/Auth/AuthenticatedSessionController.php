<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        try {
            // 1. Validación del token con la API de Cloudflare Turnstile
            $turnstileSecret = config('services.turnstile.secret_key');
            $turnstileResponse = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret'   => $turnstileSecret,
                'response' => $request->input('cf-turnstile-response'),
                'remoteip' => $request->ip(),
            ]);

            if (!$turnstileResponse->json('success')) {
                throw ValidationException::withMessages([
                    'cf-turnstile-response' => ['Falló la verificación anti-bot de Cloudflare. Intenta de nuevo.'],
                ]);
            }

            // 2. Autenticar credenciales
            $request->authenticate();

            // 3. Regenerar y guardar la sesión de inmediato
            $request->session()->regenerate();
            $request->session()->save();

            // 4. URL de redirección dinámica respetando entorno local XAMPP
            $redirectUrl = $request->root() . '/admindashboard';

            if ($request->wantsJson()) {
                return response()->json([
                    "success"   => true,
                    "data-Auth" => Auth::user(),
                    "redirect"  => $redirectUrl,
                ], 200);
            }

            return redirect()->intended($redirectUrl);

        } catch (ValidationException $Ex) {
            if ($request->wantsJson()) {
                return response()->json([
                    "success" => false,
                    "errors"  => $Ex->errors(),
                    "message" => $Ex->getMessage(),
                ], 422);
            }
            throw $Ex;
        } catch (Exception $Ex) {
            if ($request->wantsJson()) {
                return response()->json([
                    "success" => false,
                    "message" => $Ex->getMessage(),
                ], 422);
            }
            return back()->withInput()->withErrors(['error' => $Ex->getMessage()]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
