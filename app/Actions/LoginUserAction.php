<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\LoginUserData;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginUserAction
{
    public static function handle(LoginUserData $data): array|bool
    {
        $user = type(User::query()
            ->where('email', $data->email)
            ->orWhere('username', $data->email)
            ->first())->as(User::class);

        if ( ! $user || ! Hash::check($data->password, $user->password)) { //@phpstan-ignore-line
            return false;
        }

        return [
            'user'  => new UserResource($user),
            'token' => $user->createToken(Str::uuid()->toString())->plainTextToken,
        ];
    }
}
