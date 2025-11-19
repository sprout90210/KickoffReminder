<?php

namespace App\Services\Notification;

use App\Models\User;

class NotificationFactory
{
    private LineNotificationStrategy $lineStrategy;
    private EmailNotificationStrategy $emailStrategy;

    public function __construct(
        LineNotificationStrategy $lineStrategy,
        EmailNotificationStrategy $emailStrategy
    ) {
        $this->lineStrategy = $lineStrategy;
        $this->emailStrategy = $emailStrategy;
    }

    /**
     * 適切な通知Strategyを返す
     * ※通知手段が増えても対応可能にするため
     */
    public function create(User $user): NotificationStrategyInterface
    {
        if ($user->line_user_id) {
            return $this->lineStrategy;
        }

        return $this->emailStrategy;
    }
}
