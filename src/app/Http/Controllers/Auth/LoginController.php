<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->session()->regenerate();
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if(Auth::attempt($credentials, $remember)){
            return response()->json(['message' => 'ログイン成功']);
        }
        
        return response()->json(['message' => 'ログイン失敗'], 401);
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'ログアウト成功']);
    }

    
    public function check(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'isLoggedIn' => Auth::check(),
            'isLineUser' => $user ? $user->isLineUser() : false,
        ]);
    }
}
