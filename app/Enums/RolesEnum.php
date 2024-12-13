<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumsTrait;
use Filament\Support\Contracts\HasLabel;

enum RolesEnum: string implements HasLabel
{
    use EnumsTrait;

    case Admin      = 'admin';
    case SuperAdmin = 'super admin';
    case Artiste    = 'Artiste';
    case Ministry   = 'Ministry';
    case Member     = 'Member';
}
