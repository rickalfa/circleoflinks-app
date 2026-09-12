<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\User;


use Exception;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'cf-turnstile-response' => ['required'],
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'name.max' => 'El nombre no puede tener más de 255 caracteres.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'Por favor ingresa un correo electrónico válido.',
                'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.confirmed' => 'La confirmación de la contraseña no coincide.',
                'cf-turnstile-response.required' => 'Por favor completa la verificación de seguridad anti-bot.',
            ]);

            // Validación del token con la API de Cloudflare Turnstile
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

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            // Iniciar sesión y fijar la sesión de inmediato
            Auth::login($user, true);
            $request->session()->regenerate();
            $request->session()->save();

            // Construir URL de redirección dinámica que respeta la subcarpeta en XAMPP y el host local
            $redirectUrl = $request->root() . '/admindashboard';

            if ($request->wantsJson()) {
                return response()->json([
                    "success" => true,
                    "user" => $user,
                    "redirect" => $redirectUrl,
                ], 200);
            }

            return redirect($redirectUrl);

        } catch (ValidationException $Ex) {
            if ($request->wantsJson()) {
                return response()->json([
                    "success" => false,
                    "errors"  => $Ex->errors(),
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
}
