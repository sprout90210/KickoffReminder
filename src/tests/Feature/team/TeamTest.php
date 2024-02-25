<?php

namespace Tests\Feature\team;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function testTeamExists()
    {
        $team = Team::factory()->create();

        $response = $this->getJson("/api/teams/{$team->id}");

        $response->assertStatus(200);
        $response->assertJson($team->toArray());
    }

    public function testTeamDoesNotExist()
    {
        $nonExistingId = 999;
        $response = $this->getJson("/api/teams/{$nonExistingId}");

        $response->assertStatus(404);
    }
}
