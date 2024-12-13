<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;

trait UserTrait
{
    public static function getAuthUser(): ?User
    {
        return type(auth('sanctum')->user())->as(User::class);
    }
}
