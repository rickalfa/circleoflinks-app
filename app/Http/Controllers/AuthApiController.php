<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;



class AuthApiController extends Controller
{

    private function serializeToken(PersonalAccessToken $token): array
    {
        return [
            'id' => $token->id,
            'tokenable_type' => $token->tokenable_type,
            'tokenable_id' => $token->tokenable_id,
            'name' => $token->name,
            'token' => $token->token,
            'abilities' => $token->abilities,
            'last_used_at' => optional($token->last_used_at)?->toDateTimeString(),
            'created_at' => $token->created_at->toDateTimeString(),
            'updated_at' => $token->updated_at->toDateTimeString(),
        ];
    }

    public function index(Request $request)
    {
        $tokenModels = $request->user()->tokens;
        $serialized = $tokenModels->map(function (PersonalAccessToken $token) {
            return $this->serializeToken($token);
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'tokens' => $serialized,
                ],
            ]);
        }

        return view('profile.accesstoken', ['tokens' => $tokenModels]);
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        /** @var NewAccessToken $token */
        $token = $request->user()->createToken($request->name);

        $payload = $this->serializeToken($token->accessToken);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Token creado exitosamente',
                'data' => [
                    'token' => $payload,
                    'plain_text_token' => $token->plainTextToken,
                ],
            ]);
        }

        return back()->with([
            'api_token' => $token->plainTextToken
        ]);
    }


    public function destroy(Request $request, $id)
    {

        auth()->user()->tokens()->where('id',$id)->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Token eliminado',
            ]);
        }

        return back()->with('deleted','Token eliminado');

    }

}
