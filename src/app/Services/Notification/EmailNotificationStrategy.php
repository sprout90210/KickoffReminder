<?php

namespace App\Services\Notification;

use App\Mail\GameReminderMail;
use App\Models\User;
use App\Models\Game;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailNotificationStrategy implements NotificationStrategyInterface
{
    public function notify(
        User $user,
        Game $game,
        string $formattedDate,
        string $stage,
        string $remainingTimeMessage
    ): void {
        try {
            if (!$user->email) {
                Log::warning("User {$user->id} has no email. Skipping.");
                return;
            }

            Mail::send(new GameReminderMail($user->email, [
                'name' => $user->name,
                'game' => $game,
                'stage' => $stage,
                'remainingTimeMessage' => $remainingTimeMessage,
                'formattedDate' => $formattedDate,
            ]));

        } catch (\Exception $e) {
            Log::error('Email send failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
