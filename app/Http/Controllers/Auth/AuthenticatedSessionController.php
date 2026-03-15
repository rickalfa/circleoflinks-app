<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        try{

           $captchaError = $this->verifyRecaptcha($request);
           if ($captchaError) {
               return response()->json([
                   "success" => false,
                   "errors" => [
                       "recaptcha" => [$captchaError],
                   ],
               ], 422);
           }

           $request->authenticate();

           $request->session()->regenerate();


           //return redirect()->intended(RouteServiceProvider::HOME);

           return response()->json(["success" => true,
                                   "data-Auth" => Auth::user()], 200);

        }catch(Exception $Ex){

            return response()->json(["success" => false,
                              "messagge" => $Ex->getMessage()], 422);



        }

    }

    private function verifyRecaptcha(Request $request): ?string
    {
        $token = $request->input('g-recaptcha-response');
        if (! $token) {
            return 'Completa el reCAPTCHA.';
        }

        $secret = config('services.recaptcha.secret_key');
        if (! $secret) {
            return 'Configuracion reCAPTCHA incompleta.';
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        if (! $response->ok() || ! data_get($response->json(), 'success')) {
            return 'reCAPTCHA invalido. Intenta nuevamente.';
        }

        return null;
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
