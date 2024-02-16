<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_account_with_valid_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user);

        $response = $this->deleteJson('/api/user', [
            'password' => 'password',
        ]);

        $response->assertStatus(204); // アカウント削除が成功、ステータスコード 204 を確認

        // アカウントが削除されたことを確認
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_user_cannot_delete_account_with_invalid_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user);

        $response = $this->deleteJson('/api/user', [
            'password' => 'invalid-password', // 無効なパスワード
        ]);

        $response->assertStatus(403); // アカウント削除が失敗、ステータスコード 403 を確認

        // アカウントが削除されていないことを確認
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function test_user_can_delete_account_with_line_user()
    {
        $user = User::create([
            'name' => 'LINE User',
            'email' => null,
            'line_user_id' => 'line123',
            'password' => null,
        ]);

        $this->actingAs($user);

        $response = $this->deleteJson('/api/user', [
            'password' => null,
        ]);

        $response->assertStatus(204); // アカウント削除が成功、ステータスコード 204 を確認

        // アカウントが削除されたことを確認
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}
