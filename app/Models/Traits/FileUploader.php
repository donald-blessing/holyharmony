<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function explode;
use function file_exists;

trait FileUploader
{
    public function uploadFile(
        UploadedFile $file,
        ?string $folder = null,
        ?string $filename = null,
        string $disk = 'public'
    ): false|string {
        $name     = $filename ?? Str::random(25);
        $ext      = $file->getClientOriginalExtension();
        $tempName = $name;
        while (file_exists(storage_path("{$folder}/{$tempName}.{$ext}"))) {
            if (count(explode('_', $tempName)) === 1) {
                $tempName .= '_1';
            } else {
                $tempName++;
            }
        }

        $name = "{$tempName}.{$ext}";

        return $file->storeAs(
            $folder,
            $name,
            $disk
        );
    }

    public function deleteFile(string $path): bool
    {
        $path = str_replace(storage_path(''), '', $path);

        return unlink(storage_path($path));
    }

    public function uploadOne(
        UploadedFile $file,
        ?string $folder = null,
        string $disk = 'public',
        ?string $filename = null
    ): false|string {
        $name     = is_null($filename) ? Str::random(25) : $filename;
        $ext      = $file->getClientOriginalExtension();
        $tempName = $name;
        while (file_exists(storage_path("{$folder}/{$tempName}.{$ext}"))) {
            if (count(explode('_', $tempName)) === 1) {
                $tempName .= '_1';
            } else {
                $tempName++;
            }
        }

        $name = "{$tempName}.{$ext}";

        return $file->storeAs(
            $folder,
            $name,
            $disk
        );
    }

    public function deleteOne(?string $path = null, string $disk = 'public'): void
    {
        Storage::disk($disk)->delete($path);
    }
}
