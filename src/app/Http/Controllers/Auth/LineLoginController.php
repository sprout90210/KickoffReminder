<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

/**
 * LINE ログイン（Socialite）を扱うコントローラ.
 *
 * LINE の OAuth 認証画面へのリダイレクトと、
 * 戻ってきた認証コードを基にしたユーザー作成／ログイン処理を行う。
 *
 * 主なフロー:
 * 1. redirectToLine() : LINE の認証ページへ遷移
 * 2. handleLineCallback() : LINE 側の認可後にユーザー情報を受取り、本アプリ内でログイン
 */
class LineLoginController extends Controller
{
    /**
     * LINE の認証ページへリダイレクトする.
     *
     * Socialite の LINE ドライバを使用して認証 URL を生成し、
     * LINE のログイン画面へユーザーを転送する。
     *
     * @return RedirectResponse
     *
     * @apiResponse 302 LINE の認証ページへリダイレクト
     */
    public function redirectToLine(): RedirectResponse
    {
        return Socialite::driver('line')->redirect();
    }

    /**
     * LINE からのコールバックを処理する.
     *
     * LINE が返すユーザー情報（ID・名前など）を取得し、
     * line_user_id をキーとしてユーザーを作成または更新する。
     *
     * その後、自動的にログインさせ、フロントのトップページへリダイレクトする。
     *
     * @return RedirectResponse
     *
     * @apiResponse 302 "/?line_login=success" 認証成功時
     * @apiResponse 302 "/?line_login=failed"  認証失敗時
     */
    public function handleLineCallback(): RedirectResponse
    {
        try {
            /** @var \Laravel\Socialite\Contracts\User $lineUser */
            $lineUser = Socialite::driver('line')->user();

            /** @var User $user */
            $user = User::updateOrCreate(
                ['line_user_id' => $lineUser->id],
                ['name' => $lineUser->name]
            );

            Auth::login($user, true); // "remember" ON でログイン

            return redirect('/?line_login=success');

        } catch (\Exception $e) {
            Log::error('LINE login error: ' . $e->getMessage());
            return redirect('/?line_login=failed');
        }
    }
}
