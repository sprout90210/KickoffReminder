<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StandingSeeder extends Seeder
{
    public function run()
    {

        DB::table('standings')->insert([
            [
                'id' => 1,
                'position' => 1,
                'played_games' => 1,
                'won' => 25,
                'draw' => 10,
                'lost' => 3,
                'goals_for' => 87,
                'goals_against' => 33,
                'goal_difference' => 63,
                'points' => 85,
                'team_id' => 65,
                'season_id' => 1564,
            ],
            [
                'id' => 10,
                'position' => 2,
                'played_games' => 1,
                'won' => 25,
                'draw' => 10,
                'lost' => 3,
                'goals_for' => 87,
                'goals_against' => 33,
                'goal_difference' => 63,
                'points' => 85,
                'team_id' => 57,
                'season_id' => 1564,
            ],
            [
                'id' => 5,
                'position' => 3,
                'played_games' => 1,
                'won' => 25,
                'draw' => 10,
                'lost' => 3,
                'goals_for' => 87,
                'goals_against' => 33,
                'goal_difference' => 63,
                'points' => 85,
                'team_id' => 61,
                'season_id' => 1564,
            ],
            [
                'id' => 4,
                'position' => 1,
                'played_games' => 1,
                'won' => 25,
                'draw' => 10,
                'lost' => 3,
                'goals_for' => 87,
                'goals_against' => 33,
                'goal_difference' => 63,
                'points' => 85,
                'team_id' => 5,
                'season_id' => 742,
            ],


        ]);
    }
}
