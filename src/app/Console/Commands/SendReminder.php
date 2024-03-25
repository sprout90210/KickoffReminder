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

    protected $hasErrors = false;

    public function handle()
    {
        $lineService = new LineMessagingService();
        $reminderTimes = [1, 15, 60, 180, 360];
        $now = Carbon::now('UTC');

        foreach ($reminderTimes as $minute) {
            $timePoint = $now->copy()->addMinutes($minute);
            $startOfMinute = $timePoint->copy()->startOfMinute();
            $endOfMinute = $timePoint->copy()->endOfMinute();

            // 通知する試合を取得
            $gamesToRemind = Game::whereBetween('utc_date', [$startOfMinute, $endOfMinute])
                ->where('status', '=', 'TIMED')
                ->with('homeTeam', 'awayTeam', 'competition')
                ->get();

            foreach ($gamesToRemind as $game) {
                // 通知するユーザーを取得
                $usersToRemind = User::whereHas('favorites', function ($query) use ($game) {
                    $query->whereIn('team_id', [$game->home_team_id, $game->away_team_id]);
                })
                    ->where('remind_time', $minute)
                    ->where('receive_reminder', true)
                    ->get();

                // リマインダー生成
                $formattedDate = Carbon::parse($game->utc_date)->timezone('Asia/Tokyo')->format('m月d日 - H:i');
                $stage = $this->getStage($game);
                $remainingTimeMessage = $this->getRemainingTimeMessage($minute);

                //　リマインダー送信
                foreach ($usersToRemind as $user) {
                    $this->sendReminder($user, $lineService, $game, $formattedDate, $stage, $remainingTimeMessage);
                }
            }
        }

        if ($this->hasErrors) {
            return 1;
        } else {
            return 0;
        }
    }

    private function getStage($game)
    {
        if (isset($game->competition)) {
            if ($game->competition->competition_type === 'LEAGUE' && isset($game->matchday)) {
                return '第'.$game->matchday.'節';
            } elseif ($game->competition->competition_type === 'CUP' && isset($game->stage)) {
                return $game->stage;
            }
        }

        return '';
    }

    private function getRemainingTimeMessage($minute)
    {
        if ($minute == 1) {
            return 'まもなく試合が始まります！';
        } elseif ($minute < 60) {
            return 'あと'.$minute.'分でキックオフ！';
        } elseif ($minute >= 60) {
            $hours = floor($minute / 60);
            $minutes = $minute % 60;
            $timeText = $hours.'時間';
            if ($minutes > 0) {
                $timeText .= $minutes.'分';
            }

            return 'あと'.$timeText.'でキックオフ！';
        }

        return '';
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

    private function sendReminder($user, $lineService, $game, $formattedDate, $stage, $remainingTimeMessage)
    {
        if ($user->line_user_id) {
            $message = $this->buildLineMessage($user, $game, $formattedDate, $stage, $remainingTimeMessage);

            try {
                $lineService->sendMessage($user->line_user_id, $message);
            } catch (\Exception $e) {
                Log::error('LINE message sending failed: '.$e->getMessage());

                $this->hasErrors = true;
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

                $this->hasErrors = true;
            }
        }
    }
}
