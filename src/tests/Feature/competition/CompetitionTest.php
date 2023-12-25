<?php

namespace Tests\Feature\competition;

use App\Models\Competition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompetitionTest extends TestCase
{
    use RefreshDatabase;

    public function testCompetitionExists()
    {
        $competition = Competition::factory()->create();

        $response = $this->getJson("/api/competitions/{$competition->id}");

        $response->assertStatus(200);
        $response->assertJson($competition->toArray());
    }

    public function testCompetitionDoesNotExist()
    {
        $nonExistingId = 999;
        $response = $this->getJson("/api/competitions/{$nonExistingId}");

        $response->assertStatus(404);
    }
}
