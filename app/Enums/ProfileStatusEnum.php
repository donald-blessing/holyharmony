<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumsTrait;

enum ProfileStatusEnum: string
{
    use EnumsTrait;

    case AVAILABLE = 'available';
    case BOOKED    = 'booked';
}
