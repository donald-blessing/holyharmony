<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\RegisterUserAction;
use App\Data\RegisterUserData;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\JsonResponse;

class RegisterUserController extends ApiController
{
    /** Handle an incoming registration request. */
    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $response = RegisterUserAction::handle(RegisterUserData::from($request->validated()));

        return $this->sendSuccessResponse('Registration successful', $response);
    }
}
