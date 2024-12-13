<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\LogoutUserData;

class LogoutUserAction
{
    public static function handle(LogoutUserData $data): void
    {
        $user = $data->user;

        $user->tokens()->delete();
    }
}
