<?php

namespace Tests\Feature\team;

use App\Models\Competition;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamResultsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetResults()
    {
        $competition = Competition::factory()->create();
        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();
        $game = Game::factory()->create([
            'competition_id' => $competition->id,
            'home_team_id' => $team1->id,
            'away_team_id' => $team2->id,
            'status' => 'FINISHED',
            'utc_date' => now()->subDay(),
        ]);
        $game2 = Game::factory()->create([
            'competition_id' => $competition->id,
            'home_team_id' => $team1->id,
            'away_team_id' => $team2->id,
            'status' => 'IN_PLAY',
            'utc_date' => now(),
        ]);
        $game3 = Game::factory()->create([
            'competition_id' => $competition->id,
            'home_team_id' => $team1->id,
            'away_team_id' => $team2->id,
            'status' => 'TIMED', // 取得されないstatus
            'utc_date' => now(),
        ]);

        $response = $this->getJson("/api/teams/{$competition->id}/results");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id', 'competition_id', 'season_id', 'home_team_id', 'away_team_id',
                'home_team_score', 'away_team_score', 'matchday', 'status', 'stage', 'group', 'utc_date', 'last_updated',
                'competition' => ['id', 'current_season_id', 'name', 'code', 'competition_type', 'emblem'],
                'home_team' => ['id', 'name', 'short_name', 'crest', 'website_url', 'youtube_url', 'instagram_url', 'twitter_url'],
                'away_team' => ['id', 'name', 'short_name', 'crest', 'website_url', 'youtube_url', 'instagram_url', 'twitter_url'],
            ],
        ]);

        $responseData = $response->json();

        $this->assertGreaterThanOrEqual(2, count($responseData)); // FINISHEDとIN_PLAYが取得成功するのを確認
        $this->assertGreaterThanOrEqual($responseData[1]['utc_date'], $responseData[0]['utc_date']); // utc_dateが新しい順になっていることを確認

        foreach ($responseData as $gameData) {
            $this->assertContains($gameData['status'], ['FINISHED', 'IN_PLAY']);
        }
    }
}
