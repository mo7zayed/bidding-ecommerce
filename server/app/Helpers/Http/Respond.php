<?php

namespace App\Helpers\Http;

use Illuminate\Http\JsonResponse;

class Respond
{
    /**
     * Make: Handeling ApiResponse.
     *
     * @param  mixed   $data
     * @param  boolean $success
     * @param  integer $statusCode
     * @param  array   $errors
     * @return JsonResponse
     */
    public static function make($data, bool $success = true, int $statusCode = 200, array $errors = []) : JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'success' => $success,
            'payload' => $data,
            'errors' => $errors,
        ], $statusCode);
    }
}
