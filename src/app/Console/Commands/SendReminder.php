<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Mail\GameReminderMail;
use App\Services\LineMessagingService;
use App\Models\User;
use App\Models\Game;
use Carbon\Carbon;

class SendReminder extends Command
{
    protected $signature = 'command:sendReminder';
    protected $description = 'Send reminder for users favorite team games';

    public function handle()
    {
        $lineService = new LineMessagingService();
        $reminderTimes = [0, 15, 60, 180];

        foreach ($reminderTimes as $minute) {
            $startOfMinute = Carbon::now('UTC')->addMinutes($minute)->startOfMinute();
            $endOfMinute = Carbon::now('UTC')->addMinutes($minute)->endOfMinute();

            $gamesToRemind = Game::where('utc_date', '>=', $startOfMinute)
                ->where('utc_date', '<=', $endOfMinute)
                ->with('homeTeam', 'awayTeam', 'competition')
                ->get();

            foreach ($gamesToRemind as $game) {
                $usersToRemind = User::whereHas('favorites', function ($query) use ($game) {
                    $query->whereIn('team_id', [$game->home_team_id, $game->away_team_id]);
                })->where('reminder_time', $minute)
                    ->get();

                $formattedDate = Carbon::parse($game->utc_date)->timezone('Asia/Tokyo')->format('m月d日 - H:i');
                $stageMessage = $this->getStageMessage($game);
                $remainingTimeMessage = $this->getRemainingTimeMessage($minute);

                foreach ($usersToRemind as $user) {
                    $this->sendReminder($user, $lineService, $game, $formattedDate, $stageMessage, $remainingTimeMessage);
                }
            }
        }
    }


    private function getStageMessage($game)
    {
        $stageTranslations = [
            "LAST_16" => "ベスト16",
            "QUARTER_FINALS" => "準々決勝",
            "SEMI_FINALS" => "準決勝",
            "FINAL" => "決勝",
        ];

        if ($game->competition->competition_type === "LEAGUE") {
            return "第" . $game->matchday . "節";
        } else if ($game->competition->competition_type === "CUP") {
            return $stageTranslations[$game->stage] ?? '';
        }
        return '';
    }

    private function getRemainingTimeMessage($minute)
    {
        return $minute === 0 ? "まもなく試合が始まります！" : "残り" . $minute . "分でキックオフ！";
    }

    private function sendReminder($user, $lineService, $game, $formattedDate, $stageMessage, $remainingTimeMessage)
    {
        if ($user->line_user_id) {
            $message = $this->buildLineMessage($user, $game, $formattedDate, $stageMessage, $remainingTimeMessage);
            try {
                $lineService->sendMessage($user->line_user_id, $message);
            } catch (\Exception $e) {
                \Log::error("LINE message sending failed: " . $e->getMessage());
            }
        } else {
            try {
                Mail::to($user->email)->send(new GameReminderMail([
                    'game' => $game,
                    'stage' => $stageMessage,
                    'remainingTimeMessage' => $remainingTimeMessage,
                    'formattedDate' => $formattedDate,
                ]));
            } catch (\Exception $e) {
                \Log::error("Mail sending failed: " . $e->getMessage());
            }
        }
    }

    private function buildLineMessage($user, $game, $formattedDate, $stageMessage, $remainingTimeMessage)
    {
        return $user->name . "さん" . "\n" . "\n" .
            "試合が近づいています！" . "\n" . "\n" .
            $game->competition->name . $stageMessage . "\n" .
            $game->homeTeam->name . " vs " . $game->awayTeam->name . "\n" . "\n" .
            $formattedDate . "\n" . "\n" .
            $remainingTimeMessage . "\n" . "\n" .
            "お見逃しなく！";
    }
}
