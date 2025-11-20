<?php

namespace App\Services;

use App\Constants\Constants;
use App\Exceptions\TooManyRequestsException;
use App\Models\Game;
use App\Infrastructure\Api\FootballApiClient;
use Carbon\Carbon;
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

        foreach (Constants::COMPETITION_IDS as $competitionId) {
            try {
                $res = $this->footballApi->get("competitions/{$competitionId}/matches");

                /** @var array $games */
                $games = json_decode($res->getBody()->getContents())->matches;
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
                    ['id'],
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

            } catch (TooManyRequestsException $e) {
                Log::warning("UpdateGamesService: Rate limit exceeded", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                throw $e;

            } catch (GuzzleException $e) {
                Log::error("UpdateGamesService: API error for comp_id {$competitionId}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;

            } catch (\Throwable $e) {
                Log::critical("UpdateGamesService: unexpected error for comp_id {$competitionId}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;
            }
        }

        return $hasErrors;
    }
}
