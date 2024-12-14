<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\PostData;
use App\Models\Post;

class CreatePostAction
{
    public static function handle(PostData $data): Post
    {
        return Post::query()->create($data->toArray());
    }
}
