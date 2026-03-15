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
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use Illuminate\Support\Facades\DB;

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
                $validatedData = $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                    'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
                    'g-recaptcha-response' => ['required', 'string'],
                ]);

                $captchaError = $this->verifyRecaptcha($request);
                if ($captchaError) {
                    return response()->json([
                        "success" => false,
                        "message" => $captchaError,
                        "errors" => [
                            "recaptcha" => [$captchaError],
                        ],
                    ], 422);
                }

                // Encriptamos el password antes de guardar
                $validatedData['password'] = Hash::make($request->password);

                // Usamos los datos validados y encriptados, NO $request->all()
                $register = User::create($validatedData);

                
                /**
                 * Evento de envio de EMAIL
                 */
             event(new Registered($register));

               return response()->json([
                     "success" => true, 
                     "data" =>["user" => $register]
                   ], 200);


                
            } catch (ValidationException $e) {
                // Retornamos los errores estructurados que espera tu TypeScript
                return response()->json([
                    "success" => false,
                    "message" => "Los datos proporcionados no son válidos.",
                    "errors" => $e->errors() // Esto envía: { email: ["The email has already been taken."] }
                ], 422);

            } catch (\Exception $Ex) {
                return response()->json([
                    "success" => false,
                    "message" => "Error interno: " . $Ex->getMessage()
                ], 500);
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
    

 }
 
