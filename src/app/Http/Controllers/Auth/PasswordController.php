<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * パスワードリセット・変更処理を管理するコントローラ.
 *
 * ・パスワードリセットリンクの送信
 * ・トークンを使用したパスワード再設定
 * ・ログイン中ユーザーのパスワード変更
 */
class PasswordController extends Controller
{
    /**
     * パスワードリセット用メールを送信する.
     *
     * Laravel の Password Broker を利用して、
     * email に reset link を送信する。
     *
     * @param ForgotPasswordRequest $request
     *     - email: string
     *
     * @return JsonResponse
     *
     * @apiResponse 200 {"message": "メールを送信しました。"}
     * @apiResponse 404 {"error": "メールアドレスを確認できませんでした。"}
     */
    public function sendResetLink(ForgotPasswordRequest $request): JsonResponse
    {
        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'メールを送信しました。'], 200)
            : response()->json(['error' => 'メールアドレスを確認できませんでした。'], 404);
    }

    /**
     * パスワード再設定を行う.
     *
     * Password::reset() では、トークン・メールアドレス・新パスワードを検証し、
     * 検証成功時はクロージャ内で実際にパスワード更新が行われる。
     *
     * @param ResetPasswordRequest $request
     *     - email: string
     *     - password: string
     *     - password_confirmation: string
     *     - token: string
     *
     * @return JsonResponse
     *
     * @apiResponse 200 {"message": "パスワードリセットに成功しました。"}
     * @apiResponse 400 {"error": "パスワードリセットに失敗しました。"}
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            /**
             * パスワードリセット成功時に実行されるクロージャ.
             *
             * @param \App\Models\User $user
             * @param string $password リセット後の平文パスワード
             */
            function ($user, $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'パスワードリセットに成功しました。'], 200)
            : response()->json(['error' => 'パスワードリセットに失敗しました。'], 400);
    }

    /**
     * ログイン中ユーザーのパスワードを変更する.
     *
     * @param UpdatePasswordRequest $request
     *     - new_password: string
     *     - current_password: string
     *
     * @return JsonResponse
     *
     * @apiResponse 200 {"message": "パスワードが更新されました。"}
     */
    public function update(UpdatePasswordRequest $request): JsonResponse
    {
        $user = Auth::user();
        if($user){
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return response()->json(['message' => 'パスワードが更新されました。'], 200);
    }
}
