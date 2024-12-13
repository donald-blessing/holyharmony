<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumsTrait;

enum GenderEnum: string
{
    use EnumsTrait;

    case Male   = 'male';
    case Female = 'female';
}
