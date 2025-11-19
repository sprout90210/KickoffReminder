<?php

namespace App\Services;

use App\Constants\Constants;
use App\Models\Standing;
use App\Infrastructure\Api\FootballApiClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class UpdateStandingsService
 *
 * 外部 API から順位表データ（standings）を取得し、
 * standings テーブルを upsert するサービス。
 */
class UpdateStandingsService
{
    private FootballApiClient $footballApi;

    public function __construct(FootballApiClient $footballApi)
    {
        $this->footballApi = $footballApi;
    }

    /**
     * 外部APIから順位情報を取得し DB を更新する
     *
     * @return bool true: エラーあり / false: 正常終了
     *
     * @throws GuzzleException
     */
    public function update(): bool
    {
        $hasErrors = false;

        foreach (Constants::COMPETITION_IDS as $competition_id) {

            try {
                $res = $this->footballApi->get("competitions/{$competition_id}/standings");

                $resJson   = json_decode($res->getBody());
                $standings = $resJson->standings[0]->table;

                $bulkData = [];

                foreach ($standings as $standing) {
                    $bulkData[] = [
                        'season_id'        => $resJson->season->id,
                        'position'         => $standing->position,
                        'competition_id'   => $competition_id,
                        'team_id'          => $standing->team->id,
                        'played_games'     => $standing->playedGames,
                        'won'              => $standing->won,
                        'draw'             => $standing->draw,
                        'lost'             => $standing->lost,
                        'goals_for'        => $standing->goalsFor,
                        'goals_against'    => $standing->goalsAgainst,
                        'goal_difference'  => $standing->goalDifference,
                        'points'           => $standing->points,
                    ];
                }

                Standing::upsert(
                    $bulkData,
                    ['season_id', 'team_id'],
                    [
                        'competition_id',
                        'position',
                        'played_games',
                        'won',
                        'draw',
                        'lost',
                        'goals_for',
                        'goals_against',
                        'goal_difference',
                        'points'
                    ]
                );

            } catch (GuzzleException $e) {
                $hasErrors = true;
            }
        }

        return $hasErrors;
    }
}
