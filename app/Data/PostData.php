<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\CategoryEnum;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class PostData extends Data
{
    public function __construct(
        public readonly ?string $description,
        public readonly CategoryEnum $category,
        public readonly User $user,
        public readonly bool $is_downloadable,
        public readonly ?UploadedFile $upload,
    ) {}
}
