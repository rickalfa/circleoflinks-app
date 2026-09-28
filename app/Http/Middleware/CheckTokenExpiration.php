<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Laravel\Sanctum\PersonalAccessToken;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

       $token = $request->bearerToken(); 
    
       if (!$token) 
       {

        return response()->json(['error' => 'token requerido'], 401);
        
       }
       
       $tokenSanc = PersonalAccessToken::findToken($token); 

       if (!$tokenSanc)
         {
    
           return response()->json(['error' => 'token invalido'], 401);

       }

      
       if ($tokenSanc->expires_at && now()->greaterThan($tokenSanc->expires_at))
        {

         return response()->json(['error' => 'token  expirado'], 401);
        

       }



        return $next($request);
    }
}
