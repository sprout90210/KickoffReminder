<?php

namespace App\Services;

use App\Constants\Constants;
use App\Exceptions\TooManyRequestsException;
use App\Models\Season;
use App\Infrastructure\Api\FootballApiClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Class UpdateSeasonsService
 *
 * 外部APIからシーズン情報を取得し、seasons テーブルを upsert するサービス。
 */
class UpdateSeasonsService
{
    private FootballApiClient $footballApi;

    public function __construct(FootballApiClient $footballApi)
    {
        $this->footballApi = $footballApi;
    }

    /**
     * 外部 API からシーズン情報を取得し DB へ upsert する
     *
     * @return bool true: エラーあり / false: 正常終了
     *
     * @throws GuzzleException
     */
    public function update(): bool
    {
        $hasErrors = false;

        foreach (Constants::COMPETITION_IDS as $competitionId) {

            try {
                $res = $this->footballApi->get("competitions/{$competitionId}");
                $resJson = json_decode($res->getBody()->getContents());
                $seasons = $resJson->seasons;
                $bulkData = [];

                foreach ($seasons as $season) {
                    $bulkData[] = [
                        'id'             => $season->id,
                        'competition_id' => $resJson->id,
                        'start_date'     => $season->startDate,
                        'end_date'       => $season->endDate,
                    ];
                }

                Season::upsert(
                    $bulkData,
                    ['id'],
                    ['competition_id', 'start_date', 'end_date']
                );

            } catch (TooManyRequestsException $e) {
                Log::warning("UpdateSeasonsService: Rate limit exceeded", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                throw $e;

            } catch (GuzzleException $e) {
                Log::error("UpdateSeasonsService: API error for comp_id {$competitionId}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;

            } catch (\Throwable $e) {
                Log::critical("UpdateSeasonsService: unexpected error for comp_id {$competitionId}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;
            }
        }

        return $hasErrors;
    }
}
