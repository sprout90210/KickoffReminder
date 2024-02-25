<?php

namespace Tests\Feature\reminder;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateRemindTimeTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateRemindTime()
    {
        $user = User::factory()->create([
            'remind_time' => 60,
        ]);

        $newRemindTime = 1;

        $response = $this->actingAs($user)->putJson('/api/remind-time', [
            'remindTime' => $newRemindTime,
        ]);

        $response->assertStatus(200);

        $user->refresh();
        $this->assertEquals($newRemindTime, $user->remind_time);
    }
}
