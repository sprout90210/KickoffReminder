<?php

namespace Tests\Feature\favorite;

use App\Models\Favorite;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyFavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function testDestroyFavoriteSuccess()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();
        Favorite::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->deleteJson("/api/favorites/{$team->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('favorites', ['user_id' => $user->id, 'team_id' => $team->id]);
    }

    public function testDestroyFavoriteNotFound()
    {
        $user = User::factory()->create();
        $nonExistingTeamId = 999;

        $response = $this->actingAs($user)->deleteJson("/api/favorites/{$nonExistingTeamId}");

        $response->assertStatus(404);
        $response->assertJson(['error' => 'お気に入りが見つかりません。']);
    }
}
