<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumsTrait;

enum SocialiteProviderEnum: string
{
    use EnumsTrait;

    case Google   = 'google';
    case Twitter  = 'twitter';
    case GitHub   = 'github';
    case Facebook = 'facebook';
}
