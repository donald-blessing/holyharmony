<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumsTrait;

enum RolesEnum: string
{
    use EnumsTrait;

    case Admin      = 'Admin';
    case SuperAdmin = 'Super Admin';
    case Artiste    = 'Artiste';
    case Ministry   = 'Ministry';
    case Member     = 'Member';
}
