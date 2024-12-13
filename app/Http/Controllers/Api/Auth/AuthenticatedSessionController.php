<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\LogoutUserAction;
use App\Data\LogoutUserData;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends ApiController
{
    /**
     * Handle an incoming authentication request.
     *
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $response = $request->authenticate();
        if (is_bool($response)) {
            return $this->sendErrorResponse('Invalid login credentials', null, 401);
        }

        return $this->sendSuccessResponse('Login successful!', $response);
    }

    /** Destroy an authenticated session. */
    public function destroy(Request $request): JsonResponse
    {
        LogoutUserAction::handle(new LogoutUserData(user: type($request->user('sanctum'))->as(User::class)));

        return $this->sendSuccessResponse('Logout Successful.');
    }
}
