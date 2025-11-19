<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationEmailRequest;
use App\Mail\VerifyEmail;
use App\Models\PendingUser;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

/**
 * ユーザー登録時のメールアドレス認証を扱うコントローラ.
 *
 * 1. 入力されたメールアドレスに認証用リンクを送信（sendVerificationEmail）
 * 2. リンク内のトークンを検証し、本登録画面に遷移（verify）
 *
 * トークンはハッシュ化して DB に保存し、実際に URL に含めるのは
 * プレーンなトークンとなる。
 */
class EmailVerificationController extends Controller
{
    /**
     * 認証メールを送信する.
     *
     * ・ランダム文字列を生成  
     * ・DB にはハッシュ化した token を保存  
     * ・メールにはハッシュ前の token を含める  
     *
     * @param SendVerificationEmailRequest $request
     *     - email: ユーザーが入力したメールアドレス
     *
     * @return Response
     *
     * @apiResponse 204 No Content （送信成功）
     */
    public function sendVerificationEmail(SendVerificationEmailRequest $request): Response
    {
        $tokenPlain = Str::random(60);
        $tokenHash  = hash('sha256', $tokenPlain);

        /** @var PendingUser $pendingUser */
        $pendingUser = PendingUser::updateOrCreate(
            ['email' => $request->email],
            ['token' => $tokenHash]
        );

        // プレーンな token が含まれたメールを送信
        // VerifyEmail 側で URL を生成する想定
        Mail::to($pendingUser->email)->send(new VerifyEmail($pendingUser));

        return response()->noContent();
    }

    /**
     * 認証リンクのトークンを検証し、登録画面にリダイレクト.
     *
     * メールに含まれるのはプレーントークンであり、
     * DB にはハッシュ化された token が保存されているため、
     * 同一ハッシュを再計算して一致を確認する。
     *
     * @param string $token 認証リンクに含まれるプレーン token
     *
     * @return RedirectResponse
     *
     * @apiResponse 302 /?token=invalid （トークン不正または期限切れ）
     * @apiResponse 302 /registration?email=...&token=... （続きの登録画面）
     */
    public function verify(string $token): RedirectResponse
    {
        $tokenHash = hash('sha256', $token);

        /** @var PendingUser|null $pendingUser */
        $pendingUser = PendingUser::where('token', $tokenHash)
            ->where('updated_at', '>', now()->subMinutes(60)) // TODO: 期限管理用カラムを追加した方が良い
            ->first();

        // 不正・期限切れ
        if (!$pendingUser) {
            return redirect(URL::to('/?token=invalid'));
        }

        // セッションログアウトは不要（トークン使用 → 登録に進むだけ）
        $email = $pendingUser->email;

        // トークンを使い終わったので削除
        $pendingUser->delete();

        // フロントの登録画面へパラメータ付きで遷移
        return redirect(URL::to('/registration?email=' . urlencode($email) . '&token=' . $token));
    }
}
