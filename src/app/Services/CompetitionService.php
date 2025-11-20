<?php
namespace App\Services;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\Season;
use App\Models\Standing;
use Illuminate\Database\Eloquent\Collection;

class CompetitionService
{
    /**
     * @param int $competition_id
     * @return Collection<int, Standing>
     */
    public function getCurrentStandings(int $competition_id): Collection
    {
        $current_season_id = Season::where('competition_id', $competition_id)
            ->latest('start_date')
            ->value('id');

        /** @var Collection<int, Standing> $standings */
        $standings = Standing::with('team')
            ->where('season_id', $current_season_id)
            ->orderBy('position', 'asc')
            ->get();

        return $standings;
    }

    /**
     * @param int $competition_id
     * @return Collection<int, Game>
     */
    public function getResults(int $competition_id): Collection
    {
        return Game::where('competition_id', $competition_id)
            ->whereIn('status', GameStatus::resultTargets())
            ->orderBy('utc_date', 'desc')
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->limit(100)
            ->get();
    }

    /**
     * @param int $competition_id
     * @return Collection<int, Game>
     */
    public function getSchedules(int $competition_id): Collection
    {
        return Game::where('competition_id', $competition_id)
            ->whereIn('status', GameStatus::reminderTargets())
            ->orderBy('utc_date', 'asc')
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->limit(100)
            ->get();
    }
}
