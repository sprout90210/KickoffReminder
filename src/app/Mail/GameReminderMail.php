<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GameReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;

    protected $fromEmail;

    protected $toEmail;

    protected $reminder;

    public function __construct($toEmail, $reminder)
    {
        $this->name = config('mail.from.name');
        $this->fromEmail = config('mail.from.address');
        $this->toEmail = $toEmail;
        $this->reminder = $reminder;
    }

    public function build()
    {
        return $this->to($this->toEmail)
            ->from($this->fromEmail, $this->name)
            ->subject('試合時刻のお知らせ')
            ->view('emails.reminder')
            ->with([
                'name' => $this->reminder['name'],
                'game' => $this->reminder['game'],
                'stage' => $this->reminder['stage'],
                'remainingTimeMessage' => $this->reminder['remainingTimeMessage'],
                'formattedDate' => $this->reminder['formattedDate'],
            ]);
    }
}
