<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ログイン・ログアウト・ログイン状態確認を行うコントローラ.
 *
 * Sanctum（SPA 認証）を利用しており、
 * セッションベース認証により Vue / React / Nuxt などのフロントが
 * API 経由でログイン状態を取得できる。
 */
class LoginController extends Controller
{
    /**
     * ユーザーをログインさせる.
     *
     * ・バリデーション済みの email / password で認証
     * ・成功時にセッション再生成
     * ・ユーザー設定（リマインダーなど）を返却
     *
     * @param LoginRequest $request
     *     - email: string
     *     - password: string
     *     - remember?: bool
     *
     * @return JsonResponse
     *
     * @apiResponse 200 {
     *   "receiveReminder": bool,
     *   "remindTime": int|null
     * }
     * @apiResponse 401 {"error":"ログイン情報が正しくありません。"}
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->input('remember', false);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'ユーザーが見つかりません'], 500); //ここでレスポンスを返すのではなく、serviceでexceptionをthrowする
            }

            return response()->json([
                'receiveReminder' => $user->receive_reminder,
                'remindTime'      => $user->remind_time,
            ], 200);
        }

        return response()->json(['error' => 'ログイン情報が正しくありません。'], 401);
    }

    /**
     * ログアウトしセッションを無効化する.
     *
     * Sanctum の SPA 認証では、
     * セッション破棄・CSRF トークン再生成が必須。
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @apiResponse 200 {"message":"ログアウトしました。"}
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'ログアウトしました。'], 200);
    }

    /**
     * 現在のログイン状態を確認する.
     *
     * フロントの SPA が初期ロード時に状態確認する目的で使用。
     * （例：ページリロード後、Vue や React が state を復元するため）
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @apiResponse 200 {
     *   "isLoggedIn": bool,
     *   "isLineUser": bool,
     *   "remindTime": int|null,
     *   "receiveReminder": bool
     * }
     */
    public function check(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'isLoggedIn'      => Auth::check(),
            'isLineUser'      => $user ? $user->isLineUser() : false,
            'remindTime'      => $user ? $user->remind_time : false,
            'receiveReminder' => $user ? $user->receive_reminder : false,
        ], 200);
    }
}
