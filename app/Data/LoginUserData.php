<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class LoginUserData extends Data
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
