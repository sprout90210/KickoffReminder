<?php

namespace Tests\Feature\reminder;

use App\Models\Competition;
use App\Models\Favorite;
use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexReminderTest extends TestCase
{
    use RefreshDatabase;

    public function testReminderIndexWithReminders()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();
        $competition = Competition::factory()->create();
        $game = Game::factory()->create(['home_team_id' => $team->id, 'away_team_id' => $team->id, 'competition_id' => $competition->id, 'status' => 'TIMED']);
        Favorite::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->getJson('/api/reminders');

        $response->assertStatus(200);
        $response->assertJsonStructure(['reminders' => [
            '*' => ['id', 'home_team_score', 'away_team_score', 'matchday', 'status', 'stage', 'group', 'utc_date', 'last_updated', 'competition_id', 'home_team_id', 'away_team_id',
                'competition' => ['id', 'name', 'competition_type', 'current_season_id', 'emblem'],
                'home_team' => ['id', 'name', 'short_name', 'crest', 'venue'],
                'away_team' => ['id', 'name', 'short_name', 'crest', 'venue'],
            ],
        ]]);
    }

    public function testReminderIndexWithoutReminders()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/reminders');

        $response->assertStatus(200);
        $response->assertJson([
            'reminders' => [],
        ]);
    }
}
