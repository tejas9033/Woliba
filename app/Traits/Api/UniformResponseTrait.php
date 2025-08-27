<?php

namespace App\Traits\Api;

use App\Enums\HttpStatus;
use Illuminate\Http\JsonResponse;

trait UniformResponseTrait
{
    /**
     * @param            $status
     * @param            $message
     * @param            $result
     * @param HttpStatus $statusCode
     *
     * @return JsonResponse
     */
    public function sendResponse($status, $message, $result = NULL, HttpStatus $statusCode = HttpStatus::OK): JsonResponse
    {
        $response = [
            'success' => $status,
            'message' => $message,
            'data' => !empty($result) ? $result : NULL,
        ];

        return response()->json($response, $statusCode->value);
    }
}
