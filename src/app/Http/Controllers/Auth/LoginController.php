<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');
        $request->session()->invalidate();

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'ログインに成功しました。'], 200);
        }

        $request->session()->regenerate();

        return response()->json(['message' => 'ログイン情報が正しくありません。'], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'ログアウトしました。'], 200);
    }

    public function check(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'isLoggedIn' => Auth::check(),
            'isLineUser' => $user ? $user->isLineUser() : false,
        ], 200);
    }
}
