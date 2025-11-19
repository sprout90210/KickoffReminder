<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\PendingUser; // ← PendingUserモデルを使っている前提

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * メール送信対象の仮登録ユーザー
     */
    protected PendingUser $pendingUser;

    /**
     * コンストラクタ
     */
    public function __construct(PendingUser $pendingUser)
    {
        $this->pendingUser = $pendingUser;
    }

    /**
     * メールを構築して返す
     */
    public function build(): self
    {
        return $this->to($this->pendingUser->email)
            ->subject('メールアドレスの認証')
            ->view('emails.verify')
            ->with([
                'token' => $this->pendingUser->token,
            ]);
    }
}
