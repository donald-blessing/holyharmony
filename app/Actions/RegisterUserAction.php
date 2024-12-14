<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\RegisterUserData;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class RegisterUserAction
{
    public static function handle(RegisterUserData $data): array
    {
        $user = CreateUserAction::handle($data->toArray());

        AssignRoleAction::handle($user, $data->role);

        event(new Registered($user));

        return [
            'user'  => new UserResource($user),
            'token' => $user->createToken(Str::uuid()->toString())->plainTextToken,
        ];
    }
}
