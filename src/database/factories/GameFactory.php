<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'competition_id' => null,
            'season_id' => null,
            'home_team_id' => null,
            'away_team_id' => null,
            'home_team_score' => $this->faker->optional()->numberBetween(0, 10),
            'away_team_score' => $this->faker->optional()->numberBetween(0, 10),
            'matchday' => $this->faker->optional()->numberBetween(1, 38),
            'status' => $this->faker->randomElement(['FINISHED', 'TIMED', 'SCHEDULED', 'IN_PLAY', 'CANCELED']),
            'stage' => $this->faker->optional()->word,
            'group' => $this->faker->optional()->word,
            'utc_date' => $this->faker->optional()->dateTime,
            'last_updated' => $this->faker->optional()->dateTime,
        ];
    }
}
