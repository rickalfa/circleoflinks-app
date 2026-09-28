<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ResponseService
{
    public static function success(
        mixed $data = null,
        string $message = 'Operación exitosa',
        int $status = 200,
        array $meta = []
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
            'errors'  => null,
            'meta'    => $meta
        ], $status);
    }

    public static function error(
        string $message = 'Error en la operación',
        int $status = 500,
        mixed $errors = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'status'  => $status,
            'message' => $message,
            'data'    => null,
            'errors'  => $errors,
            'meta'    => []
        ], $status);
    }
}


