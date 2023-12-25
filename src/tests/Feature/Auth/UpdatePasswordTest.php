<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testPasswordUpdate()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old_password'),
        ]);

        $response = $this->actingAs($user)->putJson('/api/password/', [
            'current_password' => 'old_password',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password',
        ]);

        $response->assertStatus(200);

        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));
    }
}
