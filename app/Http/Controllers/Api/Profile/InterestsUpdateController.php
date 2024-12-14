<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Interests;

use App\Actions\InterestsAction;
use App\Data\InterestsData;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\InterestsUpdateRequest;
use Illuminate\Http\JsonResponse;

class InterestsUpdateController extends ApiController
{
    public function __invoke(InterestsUpdateRequest $request): JsonResponse
    {
        $interests = InterestsAction::handle(InterestsData::from($request->validated()));

        return $this->sendSuccessResponse('Interests updated successfully', $interests);
    }
}
