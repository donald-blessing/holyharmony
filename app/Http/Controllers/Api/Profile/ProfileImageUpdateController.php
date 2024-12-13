<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Profile;

use App\Actions\ProfileAction;
use App\Data\ProfileData;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ProfileImageUpdateRequest;
use Illuminate\Http\JsonResponse;

class ProfileImageUpdateController extends ApiController
{
    public function __invoke(ProfileImageUpdateRequest $request): JsonResponse
    {
        $profile = ProfileAction::handle(ProfileData::from($request->validated()));

        return $this->sendSuccessResponse('Profile image updated successfully', $profile);
    }
}
