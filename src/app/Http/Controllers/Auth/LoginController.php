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
        $remember = $request->input('remember', false);
        $request->session()->invalidate();

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return response()->json([
                'receiveReminder' => $user->receive_reminder,
                'remindTime' => $user->remind_time,
            ], 200);
        }

        $request->session()->regenerate();

        return response()->json(['error' => 'ログイン情報が正しくありません。'], 401);
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
            'remindTime' => $user ? $user->remind_time : false,
            'receiveReminder' => $user ? $user->receive_reminder : false,
        ], 200);
    }
}
