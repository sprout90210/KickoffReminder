<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\PendingUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_valid_token_and_email()
    {
        $pendingUser = PendingUser::create([
            'email' => 'test@example.com',
            'token' => 'valid_token',
            'created_at' => now(),
        ]);

        $response = $this->postJson('/api/register', [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => 'valid_token',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseMissing('pending_users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_registration_fails_with_invalid_token_or_email()
    {
        $response = $this->postJson('/api/register', [
            'email' => 'invalid@example.com',
            'name' => 'Test User',
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => 'invalid_token',
        ]);

        $response->assertStatus(400)
                ->assertJson(['error' => '無効なトークンまたはメールアドレスです。']);
    }

    public function test_registration_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com', // 重複するemail
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => 'token',
        ]);

        $response->assertStatus(422); // アカウント登録が失敗、ステータスコード 422 を確認
    }

    public function test_registration_fails_with_weak_password()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'weak', // 弱いパスワード
            'password_confirmation' => 'weak',
            'token' => 'token',
        ]);

        $response->assertStatus(422); // アカウント登録が失敗、ステータスコード 422 を確認
    }
}
