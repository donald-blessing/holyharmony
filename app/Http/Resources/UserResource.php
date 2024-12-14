<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'              => $this->uuid,
            'name'              => $this->name,
            'username'          => $this->username,
            'email'             => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'role'              => $this->roles()->first()?->name,
            'profile'           => $this->profile?->only([
                'stage_name',
                'photo',
                'genre',
                'phone',
                'address',
                'special_skills',
                'social_media',
                'date_of_birth',
                'gender',
            ]),
        ];
    }
}
