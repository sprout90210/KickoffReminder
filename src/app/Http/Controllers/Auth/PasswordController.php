<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'メールを送信しました。'], 200)
            : response()->json(['error' => 'メールアドレスを確認できませんでした。'], 400);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $response = Password::reset(

            $request->only('email', 'password', 'password_confirmation', 'token'),

            function ($user, $password) {
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

    public function update(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'パスワードが更新されました。'], 200);
    }
}
