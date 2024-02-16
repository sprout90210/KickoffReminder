<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        try {
            $pendingUser = PendingUser::where('token', $request->token)
                ->where('email', $request->email)
                ->where('created_at', '>', now()->subMinutes(60))
                ->first();

            if (!$pendingUser) {
                return response()->json(['error' => '無効なトークンまたはメールアドレスです。'], 400);
            }

            DB::transaction(function () use ($pendingUser, $request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $pendingUser->email,
                    'password' => Hash::make($request->password),
                ]);
        
                $pendingUser->delete();

                Auth::login($user);
            });

            return response()->json([
                'isLoggedIn' => true,
                'isLineUser' => false,
                'remindTime' => 15,
                'receiveReminder' => true,
            ], 201);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'アカウントの作成に失敗しました。'], 400);
        }
    }

    public function update(UpdateUserRequest $request)
    {
        try {
            $user = $request->user();

            if ($user->isLineUser()) {
                return response()->json(['error' => '外部ログインをしているユーザー情報は変更できません。'], 403);
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return response()->json(['message' => 'ユーザー情報が更新されました。'], 200);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => '情報更新中にエラーが発生しました。'], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = $request->user();

            if (! $user->isLineUser() && ! Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'パスワードが正しくありません。'], 403);
            }

            $user->delete();

            return response()->json(['message' => 'アカウントを削除しました。'], 204);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'エラーが発生しました。'], 500);
        }
    }
}
