<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumsTrait;
use Filament\Support\Contracts\HasLabel;

enum LocaleEnum: string implements HasLabel
{
    use EnumsTrait;

    case EnUK = 'en_UK';
    case EnUS = 'en_US';

    public static function defaultLocale(): LocaleEnum
    {
        return self::EnUK;
    }
}
