<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user'                           => $this->user->only(['uuid', 'name', 'username', 'email']),
            'stage_name'                     => $this->stage_name,
            'photo'                          => $this->photo,
            'genre'                          => $this->genre,
            'preferred_performance_location' => $this->preferred_performance_location,
            'bio'                            => $this->bio,
            'phone'                          => $this->phone,
            'address'                        => $this->address,
            'special_skills'                 => $this->special_skills,
            'preferred_event_types'          => $this->preferred_event_types,
            'social_media'                   => $this->social_media,
            'play_instruments'               => $this->play_instruments,
            'date_of_birth'                  => $this->date_of_birth,
            'gender'                         => $this->gender,
        ];
    }
}
