<?php

namespace App\Services\Notification;

use App\Models\User;
use App\Models\Game;

interface NotificationStrategyInterface
{
    /**
     * 通知を送信する
     *
     * @param User $user
     * @param Game $game
     * @param string $formattedDate
     * @param string $stage
     * @param string $remainingTimeMessage
     *
     * @return void
     */
    public function notify(
        User $user,
        Game $game,
        string $formattedDate,
        string $stage,
        string $remainingTimeMessage
    ): void;
}
