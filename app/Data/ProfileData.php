<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ProfileData extends Data
{
    public User $user;

    public function __construct(
        public int $user_id,
        public ?string $stage_name,
        public ?UploadedFile $photo,
        public ?array $genre,
        public ?string $preferred_performance_location,
        public ?string $bio,
        public ?string $phone,
        public ?array $address,
        public ?array $special_skills,
        public ?array $preferred_event_types,
        public ?array $social_media,
        public ?array $interests,
        public ?int $ministry_id,
        public readonly ?string $gender,
        public readonly ?string $data_of_birth,
    ) {
        $this->user = type(User::query()->find($user_id))->as(User::class);
    }
}
