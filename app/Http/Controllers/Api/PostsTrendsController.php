<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostsTrendsController extends ApiController
{
    public function __invoke(Request $request): JsonResponse
    {
        return $this->sendSuccessResponse('Posts trends retrieved successfully!', [
            'trending'             => PostResource::collection(Post::query()->trend()->get()),
            'latest'               => PostResource::collection(Post::query()->latest()->get()),
            'trending_by_category' => Post::trendingByCategory(),
        ]);
    }
}
