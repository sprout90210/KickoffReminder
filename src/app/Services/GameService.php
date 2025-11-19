<?php
namespace App\Services;

use App\Enums\GameStatus;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class GameService
{
    /**
     * 指定したチームIDの試合リマインダーを取得
     *
     * @param int[] $team_ids
     * @return Collection<int, Game>
     */
    public function getReminders(array $team_ids): Collection
    {
        return Game::with(['homeTeam', 'awayTeam', 'competition'])
            ->where(function ($query) use ($team_ids) {
                $query->whereIn('home_team_id', $team_ids)
                    ->orWhereIn('away_team_id', $team_ids);
            })
            ->whereIn('status', GameStatus::reminderTargets())
            ->orderBy('utc_date', 'asc')
            ->limit(30)
            ->get();
    }

    /**
     * 全体で直近の試合を取得
     *
     * @return Collection<int, Game>
     */
    public function getUpcomingGames(): Collection
    {
        return Game::whereIn('status', GameStatus::upcomingTargets())
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->orderBy('utc_date', 'asc')
            ->limit(20)
            ->get();
    }
}
