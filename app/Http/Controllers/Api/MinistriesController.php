<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MinistriesController extends ApiController
{
    public function __invoke(Request $request): JsonResponse
    {
        return $this->sendSuccessResponse(
            'Ministries retrieved successfully!',
            User::query()->ministries()->get(['id', 'name'])
        );
    }
}
