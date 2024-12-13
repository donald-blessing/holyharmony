<?php

declare(strict_types=1);

namespace App\Traits;

trait Helper
{
    protected static function removeEmptyElements(array $array): array
    {
        return array_filter($array, function ($value): bool {
            // Recursively clean arrays
            if (is_array($value)) {
                $value = self::removeEmptyElements($value);
            }

            // Remove empty values (null, '', empty arrays, etc.)
            return filled($value) || $value === 0 || $value === '0';
        });
    }
}
