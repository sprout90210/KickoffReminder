<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201); // ユーザー登録が成功、ステータスコード 201 を確認

        $this->assertAuthenticated();
    }

    public function test_registration_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com', // 重複するemail
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422); // ユーザー登録が失敗、ステータスコード 422 を確認
    }

    public function test_registration_fails_with_weak_password()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'weak', // 弱いパスワード
            'password_confirmation' => 'weak',
        ]);

        $response->assertStatus(422); // ユーザー登録が失敗、ステータスコード 422 を確認
    }
}
