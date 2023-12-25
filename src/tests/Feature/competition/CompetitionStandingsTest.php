<?php

namespace Tests\Feature\competition;

use App\Models\Competition;
use App\Models\Season;
use App\Models\Standing;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompetitionStandingsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetCurrentStandings()
    {
        $competition = Competition::factory()->create();
        $season = Season::factory()->create(['competition_id' => $competition->id]);
        $team = Team::factory()->create();
        $standing = Standing::factory()->create([
            'season_id' => $season->id,
            'team_id' => $team->id,
        ]);

        $response = $this->getJson("/api/competitions/{$competition->id}/standings");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'competition_id', 'season_id', 'team_id',
                'position', 'played_games', 'won', 'draw', 'lost',
                'goals_for', 'goals_against', 'goal_difference', 'points',
                'team' => ['id', 'name', 'short_name', 'crest', 'website_url', 'youtube_url', 'instagram_url', 'twitter_url'],
            ],
        ]);
    }
}
