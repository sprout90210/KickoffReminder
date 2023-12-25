<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'short_name' => $this->faker->optional()->lexify('???'),
            'crest' => $this->faker->optional()->imageUrl(100, 100, 'sports'),
            'venue' => $this->faker->optional()->city,
            'website_url' => $this->faker->optional()->url,
            'twitter_url' => $this->faker->optional()->url,
            'youtube_url' => $this->faker->optional()->url,
            'instagram_url' => $this->faker->optional()->url,
        ];
    }
}
