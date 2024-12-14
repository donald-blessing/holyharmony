<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
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
        ];
    }
}
