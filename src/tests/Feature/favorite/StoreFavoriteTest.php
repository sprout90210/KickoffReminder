<?php

namespace Tests\Feature\favorite;

use App\Models\Favorite;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreFavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreFavoriteSuccess()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/favorites', ['team_id' => $team->id]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'team_id' => $team->id]);
    }

    public function testStoreFavoriteAlreadyExists()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        Favorite::create(['user_id' => $user->id, 'team_id' => $team->id]);

        $response = $this->actingAs($user)->postJson('/api/favorites', ['team_id' => $team->id]);

        $response->assertStatus(409);
    }

    public function testStoreFavoriteLimitReached()
    {
        $user = User::factory()->create();
        for ($i = 0; $i < 10; $i++) {
            $team = Team::factory()->create();
            Favorite::create([
                'user_id' => $user->id,
                'team_id' => $team->id,
            ]);
        }
        $team = Team::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/favorites', ['team_id' => $team->id]);

        $response->assertStatus(422);
        $response->assertJson(['error' => 'お気に入りの登録上限に達しました。']);
    }
}
