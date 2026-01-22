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
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                    'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
                ]);

               
                $register = User::create($request->all());

                /**
                 * Evento de envio de EMAIL
                 */
                event(new Registered($register));
                
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
    

 }
 
