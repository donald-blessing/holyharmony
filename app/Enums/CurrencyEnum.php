<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\EnumsTrait;

enum CurrencyEnum: string
{
    use EnumsTrait;

    case USD = 'USD'; // United States Dollar
    case GBP = 'GBP'; // British Pound Sterling
    case NGN = 'NGN'; // Nigerian Naira

    public static function defaultCurrency(): CurrencyEnum
    {
        return self::NGN;
    }

    public function symbol(): string
    {
        return match ($this) {
            self::USD => '$',
            self::GBP => '£',
            self::NGN => '₦',
        };
    }

    public function description(): string
    {
        return $this->getLabel();
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::USD => 'United States Dollar',
            self::GBP => 'British Pound Sterling',
            self::NGN => 'Nigerian Naira',
        };
    }
}
