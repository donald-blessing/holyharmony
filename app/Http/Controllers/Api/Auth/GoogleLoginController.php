<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\CreateUserAction;
use App\Enums\SocialiteProviderEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends ApiController
{
    public function redirectToGoogle(): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return Socialite::driver(SocialiteProviderEnum::Google->value)->redirect();
    }

    public function handleGoogleCallback(Request $request): JsonResponse
    {
        try {
            $googleUser = Socialite::driver(SocialiteProviderEnum::Google->value)->user();

            $user = User::query()
                ->where('provider_id', $googleUser->id)
                ->where('provider', SocialiteProviderEnum::Google->value)
                ->first();

            if ( ! $user) {
                $user = CreateUserAction::handle([
                    'name'              => $googleUser->name,
                    'email'             => $googleUser->email,
                    'provider_id'       => $googleUser->id,
                    'provider'          => SocialiteProviderEnum::Google->value,
                    'email_verified_at' => now(),
                ]);
            }

            return $this->sendSuccessResponse('Login successful!', [
                'user'  => new UserResource($user),
                'token' => $user->createToken(Str::uuid()->toString())->plainTextToken,
            ]);
        } catch (Exception $exception) {
            return $this->sendErrorResponse('Invalid login credentials!', null, 401);
        }
    }
}
