<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\UserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends ApiController
{
    use UserTrait;

    public function __invoke(Request $request, Post $post): JsonResponse
    {
        $user = self::getAuthUser();

        // Check if the user already liked the post
        if ($post->isLikedByUser($user)) {
            $user->post->like->delete();

            return $this->sendSuccessResponse('Post unliked successfully', new PostResource($post));
        }

        // Create a like
        $post->like()->create(['user_id' => $user->id]);

        return $this->sendSuccessResponse('Liked successfully', new PostResource($post));
    }
}
