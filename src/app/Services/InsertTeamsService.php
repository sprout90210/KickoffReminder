<?php

namespace App\Services;

use App\Constants\Constants;
use App\Exceptions\TooManyRequestsException;
use App\Models\Team;
use App\Infrastructure\Api\FootballApiClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class InsertTeamsService
 *
 * 外部 API からチーム情報を取得し、
 * 該当する大会すべてのチームデータを DB に登録するサービス。
 *
 * - 外部 API 呼び出し（Guzzle）
 * - JSON パース
 * - DB トランザクション処理
 * - firstOrCreate による upsert 的保存
 *
 * @package App\Services
 */
class InsertTeamsService
{
    private FootballApiClient $footballApi;

    public function __construct(FootballApiClient $footballApi)
    {
        $this->footballApi = $footballApi;
    }

    /**
     * すべての大会（COMPETITION_IDS）に対して
     * 外部 API からチーム情報を取得し DB に保存する。
     *
     * @return bool
     *
     * @throws GuzzleException 外部 API リクエスト失敗時
     * @throws \RuntimeException JSON パース失敗またはデータ不整合時
     */
    public function insertAllCompetitionsTeams(): bool
    {
        $hasErrors = false;

        foreach (Constants::COMPETITION_IDS as $competitionId) {
            try {
                // 外部APIから JSON を取得
                $res = $this->footballApi->get("competitions/{$competitionId}/teams");
                if ($res->getStatusCode() !== 200) {
                    throw new \RuntimeException("競技ID {$competitionId} の API レスポンスが 200 ではありません");
                }
                
                $resJson = json_decode($res->getBody()->getContents());
                if (json_last_error() !== JSON_ERROR_NONE || !isset($resJson->teams)) {
                    throw new \RuntimeException("競技ID {$competitionId} の JSON が不正です");
                }
                
                // DB 保存処理
                DB::transaction(function () use ($resJson) {
                    foreach ($resJson->teams as $team) {
                        Team::firstOrCreate(
                            ['id' => $team->id],
                            [
                                'name'         => $team->name,
                                'short_name'   => $team->shortName,
                                'crest'        => null,
                                'venue'        => $team->venue,
                                'website_url'  => null,
                                'twitter_url'  => null,
                                'youtube_url'  => null,
                                'instagram_url'=> null,
                            ]
                        );
                    }
                });

            } catch (TooManyRequestsException $e) {
                Log::warning("InsertTeamsService: Rate limit exceeded", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                throw $e;

            } catch (GuzzleException $e) {
                $hasErrors = true;
                Log::error('InsertTeamsService: Guzzle Error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                continue;

            } catch (\RuntimeException $e) {
                $hasErrors = true;
                Log::error('InsertTeamsService: Runtime Error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                continue;

            } catch (\Throwable $e) {
                Log::critical("InsertTeamsService: unexpected error for comp_id {$competitionId}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                continue;
            }
        }
        return $hasErrors;
    }
}
