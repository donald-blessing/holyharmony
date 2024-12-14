<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    use UserTrait;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'description'     => $this->description,
            'category'        => $this->category,
            'views'           => $this->views,
            'downloads'       => $this->downloads,
            'is_downloadable' => $this->is_downloadable,
            'upload'          => $this->upload,
            'user'            => $this->user->only(['id', 'name', 'username', 'email']),
            'reviews'         => $this->reviews->only(['id', 'body', 'review_id']),
            'reviews_count'   => $this->reviews->count(),
            'likes_count'     => $this->likes->count(),
            'is_liked'        => $this->isLikedByUser(self::getAuthUser()),
            'created_at'      => $this->created_at,
        ];
    }
}
