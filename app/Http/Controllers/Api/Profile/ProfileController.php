<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends ApiController
{
    public function __invoke(Request $request): JsonResponse
    {
        $profile = $request->user()->profile;

        return $this->sendSuccessResponse('Profile retrieved successfully', $profile);
    }
}
