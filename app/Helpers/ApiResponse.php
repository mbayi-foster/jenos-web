<?php 
namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, string $message = 'Succès', int $code = 200): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error(string $message = 'Erreur', int $code = 400, $data = null): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
