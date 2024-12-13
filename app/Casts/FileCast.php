<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileCast implements CastsAttributes
{
    /**
     * Cast the given value to a full file URL when retrieved from the database.
     *
     * @param  mixed  $model
     * @param  mixed  $value
     * @return string|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $value ? Storage::url($value) : null;
    }

    /**
     * Prepare the given value (UploadedFile or string) for storage.
     *
     * @param  mixed  $model
     * @param  mixed  $value
     * @return string|null
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof UploadedFile) {
            return $value->store('photos', 'public');
        }

        return $value;
    }
}
