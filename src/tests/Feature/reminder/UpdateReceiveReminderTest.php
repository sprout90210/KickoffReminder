<?php

namespace Tests\Feature\reminder;

use App\Models\User;
use Tests\TestCase;

class UpdateReceiveReminderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanUpdateReceiveReminder()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->putJson('/api/receive-reminder', [
            'receiveReminder' => false,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'receive_reminder' => false,
        ]);
    }
}
