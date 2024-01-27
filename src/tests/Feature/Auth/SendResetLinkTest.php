<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendResetLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_can_be_requested()
    {
        $user = User::factory()->create();

        Notification::fake();

        $response = $this->postJson('/api/password/forgot', [
            'email' => $user->email,
        ]);

        $response->assertStatus(200);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function testSendResetLinkFailure()
    {
        $response = $this->postJson('/api/password/forgot', [
            'email' => 'nonexistent@example.com', // 存在しないメールアドレス
        ]);

        $response->assertStatus(400);
    }
}
