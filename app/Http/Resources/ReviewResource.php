<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'body'       => $this->body,
            'user'       => $this->user->only(['id', 'name', 'username', 'email']),
            'post'       => $this->post->only([
                'id', 'title', 'description', 'category', 'views', 'downloads', 'is_downloadable', 'upload',
            ]),
            'created_at' => $this->created_at,
            'reviewer'   => $this->reviewer->only(['id', 'name', 'username', 'email']),
            'replies'    => $this->replies->only(['id', 'body', 'review_id']),
            'review'     => $this->review->only(['id', 'body', 'review_id']),
        ];
    }
}
