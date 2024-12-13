<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use Spatie\LaravelData\Data;

class LogoutUserData extends Data
{
    public function __construct(
        public readonly User $user,
    ) {}
}
