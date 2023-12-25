<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Competition>
 */
class CompetitionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'current_season_id' => null,
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->bothify('??##'),
            'competition_type' => $this->faker->randomElement(['LEAGUE', 'CUP']),
            'emblem' => $this->faker->optional()->imageUrl(100, 100, 'sports'),
        ];
    }
}
