<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

use Carbon\Carbon;



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
            'has_plain_text_token' => !empty($token->plain_text_token),
            'abilities' => $token->abilities,
            'last_used_at' => optional($token->last_used_at)?->toDateTimeString(),
            'created_at' => $token->created_at->toDateTimeString(),
            'updated_at' => $token->updated_at->toDateTimeString(),
            'expires_at' => $token->expires_at
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
            'name' => 'required|string|max:255',
            'days' => 'required|numeric|min:1|max:365'
        ]);

        $days =(int) $request->input('days');
        $expires_at = Carbon::now()->addDays($days);


        /** @var NewAccessToken $token */
        $token = $request->user()->createToken($request->name);

        

        $token->accessToken->forceFill([
            'expires_at' => $expires_at,
            'plain_text_token' => Crypt::encryptString($token->plainTextToken),
        ])->save();



        $payload = $this->serializeToken($token->accessToken);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Token creado exitosamente dias : '. $days,
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

    public function showPlainToken(Request $request, $id)
    {
        $token = $request->user()->tokens()->where('id', $id)->first();

        if (!$token || empty($token->plain_text_token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token no disponible',
            ], 404);
        }

        try {
            $plainTextToken = Crypt::decryptString($token->plain_text_token);
        } catch (\Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Token no disponible',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'plain_text_token' => $plainTextToken,
            ],
        ]);
    }

}
