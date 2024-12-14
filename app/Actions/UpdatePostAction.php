<?php

declare(strict_types=1);

namespace App\Actions;

use App\Data\PostData;
use App\Models\Post;

class UpdatePostAction
{
    public static function handle(PostData $data, Post $post): Post
    {
        $post->update($data->toArray());

        return $post->fresh();
    }
}
