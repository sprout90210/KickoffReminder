<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Standing>
 */
class StandingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'competition_id' => \App\Models\Competition::factory(),
            'season_id' => \App\Models\Season::factory(),
            'team_id' => \App\Models\Team::factory(),
            'position' => $this->faker->numberBetween(1, 20),
            'played_games' => $this->faker->numberBetween(0, 38),
            'won' => $this->faker->numberBetween(0, 38),
            'draw' => $this->faker->numberBetween(0, 38),
            'lost' => $this->faker->numberBetween(0, 38),
            'goals_for' => $this->faker->numberBetween(0, 200),
            'goals_against' => $this->faker->numberBetween(0, 200),
            'goal_difference' => $this->faker->numberBetween(-100, 100),
            'points' => $this->faker->numberBetween(-100, 200),
        ];
    }
}
