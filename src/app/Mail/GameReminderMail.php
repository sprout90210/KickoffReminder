<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Game;

class GameReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $reminder;

    public function __construct($reminder)
    {
        $this->reminder = $reminder;
    }

    public function build()
    {
        return $this->subject('試合時刻のお知らせ')
                    ->view('emails.game_reminder', [
                        'game' => $this->reminder['game'],
                        'stage' => $this->reminder['stage'],
                        'remainingTimeMessage' => $this->reminder['remainingTimeMessage'],
                        'formattedDate' => $this->reminder['formattedDate'],
                    ]);
    }
}
