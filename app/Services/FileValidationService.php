<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class FileValidationService
{
    /** Check if file is an image using basic file extension check */
    public function isImageByExtension(UploadedFile|File $file): bool
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];

        return in_array(
            mb_strtolower($file->getClientOriginalExtension()),
            $allowedExtensions,
            true
        );
    }

    /** Check if file is an image using MIME type */
    public function isImageByMimeType(UploadedFile|File $file): bool
    {
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/bmp',
            'image/svg+xml',
        ];

        return in_array(
            mb_strtolower($file->getMimeType()),
            $allowedMimeTypes,
            true
        );
    }

    /** Most comprehensive image validation using extension, MIME type, and getimagesize() */
    public function isImageComprehensive(UploadedFile|File $file): bool
    {
        // Check extension
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
        $extension         = mb_strtolower($file->getClientOriginalExtension());

        if ( ! in_array($extension, $allowedExtensions, true)) {
            return false;
        }

        // Check MIME type
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/bmp',
            'image/svg+xml',
        ];
        $mimeType = mb_strtolower($file->getMimeType());

        if ( ! in_array($mimeType, $allowedMimeTypes, true)) {
            return false;
        }

        // Final check using PHP's getimagesize()
        try {
            $imageInfo = @getimagesize($file->getRealPath());

            return $imageInfo !== false;
        } catch (Exception $e) {
            return false;
        }
    }

    /** Validate image file with additional size and dimension constraints */
    public function validateImage(
        $file,
        int $maxSizeInKb = 5120,
        int $maxWidth = 3000,
        int $maxHeight = 3000
    ): bool {
        if ( ! $this->isImageComprehensive($file)) {
            return false;
        }

        // Check file size (max 5MB by default)
        if ($file->getSize() > $maxSizeInKb * 1024) {
            return false;
        }

        // Get image dimensions
        $imageInfo = getimagesize($file->getRealPath());

        if ($imageInfo === false) {
            return false;
        }

        // Check image dimensions
        return
            $imageInfo[0] <= $maxWidth &&
            $imageInfo[1] <= $maxHeight;
    }
}
