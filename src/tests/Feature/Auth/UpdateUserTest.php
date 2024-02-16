<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_with_valid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->putJson('/api/user', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertStatus(200); // アカウント情報変更が成功、ステータスコード 200 を確認

        // アカウントのデータが更新されたことを確認
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_user_update_fails_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->putJson('/api/user', [
            'name' => '',
            'email' => 'invalid-email', //　無効なemail
        ]);

        $response->assertStatus(422); // アカウント情報変更が失敗、ステータスコード 422 を確認
    }
}
