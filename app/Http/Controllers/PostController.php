<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreatePostAction;
use App\Actions\UpdatePostAction;
use App\Data\PostData;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends ApiController
{
    /** Display a listing of the resource. */
    public function index(Request $request): JsonResponse
    {
        return $this->sendSuccessResponse(
            'Posts retrieved successfully!',
            PostResource::collection($request->user()->posts)
        );
    }

    /** Store a newly created resource in storage. */
    public function store(PostRequest $request): JsonResponse
    {
        $post = CreatePostAction::handle(PostData::from($request->validated()));

        return $this->sendSuccessResponse('Post has been created successfully!', new PostResource($post));
    }

    /** Display the specified resource. */
    public function show(Post $post): JsonResponse
    {
        $post->update(['views' => $post->views + 1]);

        return $this->sendSuccessResponse('Post has been retrieved successfully!', new PostResource($post->refresh()));
    }

    /** Update the specified resource in storage. */
    public function update(PostRequest $request, Post $post): JsonResponse
    {
        $post = UpdatePostAction::handle(PostData::from($request->validated()), $post);

        return $this->sendSuccessResponse('Post has been updated successfully!', new PostResource($post));
    }

    /** Remove the specified resource from storage. */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return $this->sendSuccessResponse('Post has been deleted successfully!');
    }
}
