<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pendingUser;

    public function __construct($pendingUser)
    {
        $this->pendingUser = $pendingUser;
    }

    public function build()
    {
        return $this->to($this->pendingUser->email)
            ->subject('メールアドレスの認証')
            ->view('emails.verify')
            ->with([
                'token' => $this->pendingUser->token,
            ]);
    }
}
