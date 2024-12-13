<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stage_name' => fake()->name,
            'photo'      => fake()->imageUrl(400, 400, 'people'), // Random image URL
            'genre'      => fake()->randomElements(
                ['Pop', 'Rock', 'Jazz', 'Classical'],
                rand(1, 3)
            ), // Random genres
            'preferred_performance_location' => fake()->city,
            'bio'                            => fake()->paragraphs(3, true), // Random text for biography
            'phone'                          => fake()->phoneNumber,
            'address'                        => [
                'street'  => fake()->streetAddress,
                'city'    => fake()->city,
                'state'   => fake()->state,
                'country' => fake()->country,
            ],
            'special_skills' => fake()->randomElements(
                ['Singing', 'Dancing', 'Acting'],
                rand(1, 3)
            ),
            'interests' => fake()->randomElements(
                ['Concert', 'Festival', 'Corporate Event'],
                rand(1, 2)
            ),
            'social_media' => [
                'facebook'  => fake()->url,
                'twitter'   => fake()->url,
                'instagram' => fake()->url,
            ],
            'user_id' => User::factory(),
        ];
    }
}
