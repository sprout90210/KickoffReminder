<?php

namespace App\Services;

use App\Constants\Constants;
use App\Models\Game;
use Carbon\Carbon;
use App\Infrastructure\Api\FootballApiClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Class UpdateGamesService
 *
 * 外部APIから試合情報を取得し、games テーブルを upsert するサービス。
 *
 * @package App\Services
 */
class UpdateGamesService
{
    private FootballApiClient $footballApi;

    public function __construct(FootballApiClient $footballApi)
    {
        $this->footballApi = $footballApi;
    }
    
    /**
     * 外部APIから試合情報を取得してDBを更新する
     *
     * @return bool true: エラーあり / false: エラーなし
     *
     * @throws GuzzleException 外部APIエラー時
     */
    public function update(): bool
    {
        $hasErrors = false;

        foreach (Constants::COMPETITION_IDS as $competition_id) {

            try {
                $res = $this->footballApi->get("competitions/{$competition_id}/matches");

                /** @var array $games */
                $games = json_decode($res->getBody())->matches;

                $bulkData = [];

                foreach ($games as $game) {
                    $bulkData[] = [
                        'id'              => $game->id,
                        'competition_id'  => $game->competition->id,
                        'season_id'       => $game->season->id,
                        'home_team_id'    => $game->homeTeam->id,
                        'away_team_id'    => $game->awayTeam->id,
                        'home_team_score' => $game->score->fullTime->home,
                        'away_team_score' => $game->score->fullTime->away,
                        'status'          => $game->status,
                        'stage'           => $game->stage,
                        'group'           => $game->group,
                        'matchday'        => $game->matchday,
                        'utc_date'        => Carbon::parse($game->utcDate)->format('Y-m-d H:i:s'),
                        'last_updated'    => Carbon::parse($game->lastUpdated)->format('Y-m-d H:i:s'),
                    ];
                }

                Game::upsert(
                    $bulkData,
                    ['id'], // unique key
                    [
                        'competition_id',
                        'season_id',
                        'home_team_id',
                        'away_team_id',
                        'home_team_score',
                        'away_team_score',
                        'status',
                        'stage',
                        'group',
                        'matchday',
                        'utc_date',
                        'last_updated'
                    ]
                );

            } catch (GuzzleException $e) {
                Log::error("UpdateGames: API error for comp_id {$competition_id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;

            } catch (\Throwable $e) {
                Log::critical("UpdateGames: unexpected error for comp_id {$competition_id}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                $hasErrors = true;
            }
        }

        return $hasErrors;
    }
}
