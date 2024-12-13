<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;

class CreateUserAction
{
    public static function handle(array $data): User
    {
        return User::query()->create($data);
    }
}
