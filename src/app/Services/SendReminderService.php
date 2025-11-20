<?php

namespace App\Services;

use App\Constants\Constants;
use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;
use App\Services\Notification\NotificationFactory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * 試合開始前のリマインダー通知を送信するサービスクラス.
 *
 * - 指定された分前（1, 15, 60, 180, 360）の試合を検索
 * - 対象ユーザーを抽出（お気に入りチーム & 設定時刻一致）
 * - LINE または Email で通知送信
 * - 通知失敗時はログ出力
 */
class SendReminderService
{
    private NotificationFactory $notificationFactory;

    public function __construct(NotificationFactory $notificationFactory)
    {
        $this->notificationFactory = $notificationFactory;
    }

    /**
     * @var bool 通知処理中にエラーが発生したかどうか
     */
    private bool $hasErrors = false;

    /**
     * リマインダー通知のメイン処理
     *
     * @return bool true: エラーあり / false: 問題なし
     */
    public function execute(): bool
    {
        $now = Carbon::now('UTC');

        foreach (Constants::REMIND_TIMES as $remindTime) {
            $timePoint = $now->copy()->addMinutes($remindTime);
            $startOfMinute = $timePoint->copy()->startOfMinute();
            $endOfMinute = $timePoint->copy()->endOfMinute();

            /** @var Collection<int, Game> $gamesToRemind */
            $gamesToRemind = Game::whereBetween('utc_date', [$startOfMinute, $endOfMinute])
                ->where('status', '=', GameStatus::TIMED)
                ->with('homeTeam', 'awayTeam', 'competition')
                ->get();

            foreach ($gamesToRemind as $game) {
                $this->sendReminder($game, $remindTime);
            }
        }

        return $this->hasErrors;
    }

    /**
     * 試合のステージ（節・ラウンド）名を返す
     *
     * @param Game $game
     * @return string
     */
    private function getStage(Game $game): string
    {
        if (isset($game->competition)) {
            if ($game->competition->competition_type === 'LEAGUE' && isset($game->matchday)) {
                return '第' . $game->matchday . '節';
            }
            if ($game->competition->competition_type === 'CUP' && isset($game->stage)) {
                return $game->stage;
            }
        }
        return '';
    }

    /**
     * ●分後のキックオフに応じたメッセージを返す
     *
     * @param int $minutesBeforeKickoff
     * @return string
     */
    private function getRemainingTimeMessage(int $minutesBeforeKickoff): string
    {
        if ($minutesBeforeKickoff == 1) {
            return 'まもなく試合が始まります！';
        } else if ($minutesBeforeKickoff < 60) {
            return 'あと' . $minutesBeforeKickoff . '分でキックオフ！';
        }
        $hours = intdiv($minutesBeforeKickoff, 60);
        $remainingMinutes = $minutesBeforeKickoff % 60;
        $timeText = $hours . '時間';
        if ($remainingMinutes > 0) {
            $timeText .= $remainingMinutes . '分';
        }
        return 'あと' . $timeText . 'でキックオフ！';
    }

    /**
     * LINE または Email でリマインダーを送信する.
     *
     * @param Game $game
     * @param int $remindTime
     * 
     * @return void
     */
    private function sendReminder(
        Game $game,
        int $remindTime,
    ): void {
        /** @var Collection<int, User> $usersToRemind */
        $usersToRemind = User::whereHas('favorites', function ($query) use ($game) {
            $query->whereIn('team_id', [$game->home_team_id, $game->away_team_id]);
        })
            ->where('remind_time', $remindTime)
            ->where('receive_reminder', true)
            ->get();

        $formattedDate = Carbon::parse($game->utc_date)
            ->timezone('Asia/Tokyo')
            ->format('m月d日 - H:i');

        $stage = $this->getStage($game);
        $remainingTimeMessage = $this->getRemainingTimeMessage($remindTime);

        foreach ($usersToRemind as $user) {
            try {
                $strategy = $this->notificationFactory->create($user);
                $strategy->notify(
                    $user,
                    $game,
                    $formattedDate,
                    $stage,
                    $remainingTimeMessage
                );
                
            } catch (\Exception $e) {
                Log::error('SendReminderService: Reminder send failed: ' . $e->getMessage());
                $this->hasErrors = true;
            }
        }
    }
}
