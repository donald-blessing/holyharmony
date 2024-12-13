<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Exceptions\UploadFileException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Throwable;

trait UploadAble
{
    use FileUploader;
    use InteractsWithMedia;

    public static function getCollection(): string
    {
        return Str::plural(class_basename(static::class));
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10);

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600);
    }

    /**
     * Add a file to the media library. The file will be removed from
     * its original location.
     *
     *
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws Throwable
     */
    public function uploadMedia(string|UploadedFile $file, ?string $filename = null): Media
    {
        return $this->addMedia($file)
            ->usingName($filename ?? Str::random(40))
            ->toMediaCollection($this->getCollection());
    }

    /** @throws UploadFileException */
    public function uploadMediaFromDisk(
        string $key,
        ?string $filename = null,
        string $disk = 'public'
    ): Media {
        try {
            return $this->addMediaFromDisk($key, $disk)
                ->usingName($filename ?? Str::random(40))
                ->toMediaCollection($this->getCollection());
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            report($e);

            throw new UploadFileException($e->getMessage(), $e->getCode(), $e);
        } catch (Throwable $e) {
            report($e);

            throw new UploadFileException('There was a problem uploading the file!', $e->getCode(), $e);
        }
    }

    /** @throws UploadFileException */
    public function uploadMediaFromUrl(string $url, ?string $filename = null): Media
    {
        try {
            return $this->addMediaFromUrl($url)
                ->usingName($filename ?? Str::random(40))
                ->toMediaCollection($this->getCollection());
        } catch (FileDoesNotExist|FileIsTooBig|FileCannotBeAdded $e) {
            report($e);

            throw new UploadFileException($e->getMessage(), $e->getCode(), $e);
        } catch (Throwable $e) {
            report($e);

            throw new UploadFileException('There was an error uploading the file from the url', $e->getCode(), $e);
        }
    }

    /** @throws UploadFileException */
    public function uploadMediaFromRequest(string $keyName, ?string $filename = null): Media
    {
        try {
            return $this->addMediaFromRequest($keyName)
                ->usingName($filename ?? Str::random(40))
                ->toMediaCollection($this->getCollection());
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            report($e);

            throw new UploadFileException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function uploadMultipleMediaFromRequest(array $keys): Collection|array
    {
        return $this->addMultipleMediaFromRequest($keys)
            ->each(fn ($fileAdder) => $fileAdder->toMediaCollection($this->getCollection()));
    }

    public function uploadAllMediaFromRequest(): Collection|array
    {
        return $this->addAllMediaFromRequest()
            ->each(fn ($fileAdder) => $fileAdder->toMediaCollection($this->getCollection()));
    }

    /** @throws UploadFileException */
    public function uploadMediaFromBase64(
        string $base64data,
        ?string $filename = null,
        ?string $allowedMimeTypes = null
    ): Media {
        try {
            return $this->addMediaFromBase64($base64data, $allowedMimeTypes)
                ->usingName($filename ?? Str::random(40))
                ->toMediaCollection($this->getCollection());
        } catch (FileDoesNotExist|FileIsTooBig|InvalidBase64Data|FileCannotBeAdded $e) {
            report($e);

            throw new UploadFileException($e->getMessage(), $e->getCode(), $e);
        } catch (Throwable $e) {
            report($e);

            throw new UploadFileException('There was a problem uploading the media from the base64 media', $e->getCode(), $e);
        }
    }

    /**
     * Copy a file to the media library.
     *
     * @throws UploadFileException
     */
    public function copyMediaFile(string|UploadedFile $file, string $collection): Media
    {
        try {
            return $this->copyMedia($file)->toMediaCollection($collection);
        } catch (FileDoesNotExist|FileIsTooBig $e) {
            report($e);

            throw new UploadFileException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /** Get files from folder and upload */
    public function getFiles(string $directory): array
    {
        return File::Files($directory);
    }

    public function folderExists(string $directory): bool
    {
        return File::isDirectory($directory);
    }

    /**
     * Add a file to the media library. The file will be removed from
     * its original location.
     *
     *
     * @throws UploadFileException
     */
    public function attachMedia(string $directory, string $collection): void
    {
        foreach ($this->getFiles($directory) as $file) {
            try {
                $this->uploadMedia($file->getPathname(), $collection);
            } catch (FileDoesNotExist|FileIsTooBig $e) {
                report($e);

                throw new UploadFileException($e->getMessage(), $e->getCode(), $e);
            } catch (Throwable $e) {
                report($e);

                throw new UploadFileException('There was an error attaching the media!', $e->getCode(), $e);
            }
        }
    }

    /**
     * Delete media item
     *
     *
     * @throws UploadFileException
     */
    public function deleteMediaItem(Media|int $media): void
    {
        try {
            if ( ! ($media instanceof Media)) {
                $media = Media::query()->findOrFail($media);
            }

            $media->delete();
        } catch (Throwable $throwable) {
            report($throwable);

            throw new UploadFileException('An error occurred while trying to delete the file!', $throwable->getCode(), $throwable);
        }
    }
}
