<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Traits;

use Illuminate\Http\JsonResponse;

trait HasApiResponse
{
    protected function apiRequestResponse($status, $message, $data, $errors, $meta): array
    {
        return [
            'status'  => $status ?? 'failed',
            'message' => $message ?? 'No message available',
            'data'    => $data ?? null,
            'errors'  => $errors ?? null,
            'meta'    => $meta,
        ];
    }

    public function sendSuccessResponse(
        $message,
        $data = null,
        $code = 200,
        $meta = []
    ): JsonResponse {
        $response = $this->apiRequestResponse('success', $message, $data, null, $meta);

        return response()->json($response, $code);
    }

    public function sendErrorResponse(
        $message,
        $errors = null,
        $code = 400,
        $meta = []
    ): JsonResponse {
        $response = $this->apiRequestResponse('failed', $message, null, $errors, $meta);

        return response()->json($response, $code);
    }
}
