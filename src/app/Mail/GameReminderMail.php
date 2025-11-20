<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GameReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    protected string $name;

    /** @var string */
    protected string $fromEmail;

    /** @var string */
    protected string $toEmail;

    /** @var array<string, mixed> */
    protected array $reminder;

    /**
     * @param string $toEmail
     * @param array<string, mixed> $reminder
     */
    public function __construct(string $toEmail, array $reminder)
    {
        $this->name = config('mail.from.name');
        $this->fromEmail = config('mail.from.address');
        $this->toEmail = $toEmail;
        $this->reminder = $reminder;
    }

    public function build(): self
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
