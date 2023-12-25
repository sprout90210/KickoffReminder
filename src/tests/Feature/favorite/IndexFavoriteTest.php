<?php

namespace Tests\Feature\favorite;

use App\Models\Favorite;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexFavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function testFavoriteIndexWithFavorites()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();
        Favorite::create([
            'user_id' => $user->id,
            'team_id' => $team->id,
        ]);

        $response = $this->actingAs($user)->getJson('/api/favorites');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['user_id', 'team_id', 'team' => ['id', 'name', 'short_name', 'crest', 'venue', 'website_url', 'youtube_url', 'twitter_url', 'instagram_url']],
        ]);
    }

    public function testFavoriteIndexWithoutFavorites()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/favorites');

        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
