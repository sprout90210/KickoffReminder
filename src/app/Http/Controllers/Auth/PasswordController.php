<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $response = Password::sendResetLink(
            $request->only('email')
        );
        return $response == Password::RESET_LINK_SENT
                    ? response()->json(['message' => 'メールを送信しました'], 200)
                    : response()->json(['message' => 'メール送信できませんでした'], 500);
    }


    public function reset(ResetPasswordRequest $request)
    {
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
                
                event(new PasswordReset($user));
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? response()->json(['message' => 'パスワードリセットに成功しました'], 200)
                    : response()->json(['message' => 'パスワードリセットに失敗しました'], 500);
    }
}
