<?php
namespace App\Services;

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\Standing;
use Illuminate\Database\Eloquent\Collection;

class TeamService
{
    private CompetitionService $competitionService;

    public function __construct(CompetitionService $competitionService)
    {
        $this->competitionService = $competitionService;
    }

    /**
     * チームの順位情報を取得
     *
     * @param int $team_id
     * @return Collection<int, Standing>
     */
    public function getStandings(int $team_id): Collection
    {
        $competition_id = Standing::where('team_id', $team_id)
            ->with(['season' => function ($query) {
                $query->orderBy('start_date', 'desc');
            }])
            ->value('competition_id');

        /** @var Collection<int, Standing> $team_standings */
        $team_standings = $this->competitionService->getCurrentStandings($competition_id);

        return $team_standings;
    }

    /**
     * チームの試合結果（完了済み・進行中）を取得
     *
     * @param int $team_id
     * @return Collection<int, Game>
     */
    public function getResults(int $team_id): Collection
    {
        return Game::where(function ($query) use ($team_id) {
                $query->where('home_team_id', $team_id)
                    ->orWhere('away_team_id', $team_id);
            })
            ->whereIn('status', GameStatus::resultTargets())
            ->orderBy('utc_date', 'desc')
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->limit(100)
            ->get();
    }

    /**
     * チームの予定されている試合一覧を取得
     *
     * @param int $team_id
     * @return Collection<int, Game>
     */
    public function getSchedules(int $team_id): Collection
    {
        return Game::where(function ($query) use ($team_id) {
                $query->where('home_team_id', $team_id)
                    ->orWhere('away_team_id', $team_id);
            })
            ->whereIn('status', GameStatus::reminderTargets())
            ->orderBy('utc_date', 'asc')
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->limit(50)
            ->get();
    }

    /**
     * チームの次の試合を取得
     *
     * @param int $team_id
     * @return Game|null
     */
    public function getNextGame(int $team_id): ?Game
    {
        return Game::where(function ($query) use ($team_id) {
                $query->where('home_team_id', $team_id)
                    ->orWhere('away_team_id', $team_id);
            })
            ->where('status', GameStatus::TIMED)
            ->orderBy('utc_date', 'asc')
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->first();
    }    
}
