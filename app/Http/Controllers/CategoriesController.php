<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CategoryEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends ApiController
{
    public function __invoke(Request $request): JsonResponse
    {
        return $this->sendSuccessResponse('Categories retrieved successfully!', CategoryEnum::toArray());
    }

    public function show(Request $request, string $category): JsonResponse
    {
        return $this->sendSuccessResponse(
            'Category posts retrieved successfully!',
            PostResource::collection(Post::query()->where('category', $category)->get())
        );
    }
}
