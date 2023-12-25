<?php

namespace App\Console\Commands;

use App\Mail\GameReminderMail;
use App\Models\Game;
use App\Models\User;
use App\Services\LineMessagingService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReminder extends Command
{
    protected $signature = 'command:sendReminder';

    protected $description = 'Send reminder for users favorite team games';

    public function handle()
    {
        $lineService = new LineMessagingService();
        $reminderTimes = [1, 15, 60, 180];

        foreach ($reminderTimes as $minute) {
            $startOfMinute = Carbon::now('UTC')->addMinutes($minute)->startOfMinute();
            $endOfMinute = Carbon::now('UTC')->addMinutes($minute)->endOfMinute();

            // 通知する試合を取得
            $gamesToRemind = Game::where('utc_date', '>=', $startOfMinute)
                ->where('utc_date', '<=', $endOfMinute)
                ->with('homeTeam', 'awayTeam', 'competition')
                ->get();

            foreach ($gamesToRemind as $game) {
                // 通知するユーザーを取得
                $usersToRemind = User::whereHas('favorites', function ($query) use ($game) {
                    $query->whereIn('team_id', [$game->home_team_id, $game->away_team_id]);
                })->where('remind_time', $minute)
                    ->get();

                $formattedDate = Carbon::parse($game->utc_date)->timezone('Asia/Tokyo')->format('m月d日 - H:i');
                $stage = $this->getStage($game);
                $remainingTimeMessage = $this->getRemainingTimeMessage($minute);

                foreach ($usersToRemind as $user) {
                    $this->sendReminder($user, $lineService, $game, $formattedDate, $stage, $remainingTimeMessage);
                }
            }
        }
    }

    private function getStage($game)
    {
        $stageTranslations = [
            'LAST_16' => 'ベスト16',
            'QUARTER_FINALS' => '準々決勝',
            'SEMI_FINALS' => '準決勝',
            'FINAL' => '決勝',
        ];

        if ($game->competition->competition_type === 'LEAGUE') {
            return '第'.$game->matchday.'節';
        } elseif ($game->competition->competition_type === 'CUP') {
            return $stageTranslations[$game->stage] ?? '';
        }

        return '';
    }

    private function getRemainingTimeMessage($minute)
    {
        switch ($minute) {
            case 1:
                return 'まもなく試合が始まります！';
            case 60:
                return '残り1時間でキックオフ！';
            case 180:
                return '残り3時間でキックオフ！';
            default:
                return '残り'.$minute.'分でキックオフ！';
        }
    }

    private function sendReminder($user, $lineService, $game, $formattedDate, $stage, $remainingTimeMessage)
    {
        if ($user->line_user_id) {
            $message = $this->buildLineMessage($user, $game, $formattedDate, $stage, $remainingTimeMessage);
            try {
                $lineService->sendMessage($user->line_user_id, $message);
            } catch (\Exception $e) {
                Log::error('LINE message sending failed: '.$e->getMessage());
            }
        } else {
            try {
                Mail::send(new GameReminderMail($user->email, [
                    'name' => $user->name,
                    'game' => $game,
                    'stage' => $stage,
                    'remainingTimeMessage' => $remainingTimeMessage,
                    'formattedDate' => $formattedDate,
                ]));
            } catch (\Exception $e) {
                Log::error('Mail sending failed: '.$e->getMessage());
            }
        }
    }

    private function buildLineMessage($user, $game, $formattedDate, $stage, $remainingTimeMessage)
    {
        return "$user->name さん\n\n".
            "試合が近づいています！\n\n".
            "{$game->competition->name}{$stage}\n".
            "{$game->homeTeam->name} vs {$game->awayTeam->name}\n\n".
            "$formattedDate\n\n".
            "$remainingTimeMessage\n\n".
            'お見逃しなく！';
    }
}
