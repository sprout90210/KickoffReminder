<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return response()->json(['isLoggedIn' => true], 200);
    }


    public function update(Request $request)
    {
        try {
            $user = $request->user();
            if ($user->isLineUser()) {
                return response()->json(['error' => '外部ログインをしている場合はユーザーは変更できません。'], 403);
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
            return response()->json(['message' => 'ユーザー情報が更新されました。'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => '情報更新中にエラーが発生しました。'], 500);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user->isLineUser()) {
                if (!Hash::check($request->password, $user->password)) {
                    return response()->json(['message' => 'パスワードが正しくありません。'], 403);
                }
            }

            $user->delete();
            return response()->json(['message' => 'アカウントを削除しました。'], 204);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'アカウント削除中にエラーが発生しました。'], 500);
        }
    }



}
