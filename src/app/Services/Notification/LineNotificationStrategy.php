<?php

namespace App\Services\Notification;

use App\Models\User;
use App\Models\Game;
use App\Services\LineMessagingService;
use Illuminate\Support\Facades\Log;

class LineNotificationStrategy implements NotificationStrategyInterface
{
    private LineMessagingService $lineService;

    public function __construct(LineMessagingService $lineService)
    {
        $this->lineService = $lineService;
    }

    public function notify(
        User $user,
        Game $game,
        string $formattedDate,
        string $stage,
        string $remainingTimeMessage
    ): void {
        $competitionName = $game->competition?->name ?? '不明な大会';
        $homeName = $game->homeTeam?->name ?? '不明なチーム';
        $awayName = $game->awayTeam?->name ?? '不明なチーム';

        $message = "{$user->name} さん\n\n" .
            "試合が近づいています！\n\n" .
            "{$competitionName}{$stage}\n" .
            "{$homeName} vs {$awayName}\n\n" .
            "{$formattedDate}\n\n" .
            "{$remainingTimeMessage}\n\n" .
            'お見逃しなく！';

        try {
            $this->lineService->sendMessage($user->line_user_id, $message);

        } catch (\Exception $e) {
            Log::error('LINE message failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
