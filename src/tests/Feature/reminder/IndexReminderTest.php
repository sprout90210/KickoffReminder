<?php

namespace Tests\Feature\reminder;

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
        $game = Game::factory()->create(['home_team_id' => $team->id, 'away_team_id' => $team->id, 'status' => 'TIMED']);
        Favorite::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->getJson('/api/reminders');

        $response->assertStatus(200);
    }

    public function testReminderIndexWithoutReminders()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/reminders');

        $response->assertStatus(200);
        $response->assertJson([
            'reminders' => [],
            'remindTime' => $user->remind_time,
        ]);
    }
}
