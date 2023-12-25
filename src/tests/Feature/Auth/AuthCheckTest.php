<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthCheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCheckLoggedInUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/check');

        $response->assertStatus(200);

        $response->assertJson([
            'isLoggedIn' => true,
            'isLineUser' => $user->isLineUser(),
        ]);
    }

    public function testCheckLoggedOutUser()
    {
        $response = $this->getJson('/api/check');

        $response->assertStatus(200);

        $response->assertJson([
            'isLoggedIn' => false,
            'isLineUser' => false,
        ]);
    }
}
