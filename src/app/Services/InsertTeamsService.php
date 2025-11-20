<?php

namespace App\Services;

use App\Constants\Constants;
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
                $response = $this->footballApi->get("competitions/{$competitionId}/teams");
                if ($response->getStatusCode() !== 200) {
                    throw new \RuntimeException("競技ID {$competitionId} の API レスポンスが 200 ではありません");
                }
                
                $json = json_decode($response->getBody());
                if (json_last_error() !== JSON_ERROR_NONE || !isset($json->teams)) {
                    throw new \RuntimeException("競技ID {$competitionId} の JSON が不正です");
                }
                
                // DB 保存処理
                DB::transaction(function () use ($json) {
                    foreach ($json->teams as $team) {
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

            } catch (GuzzleException $e) {
                $hasErrors = true;
                Log::error('InsertTeams Guzzle Error', ['error' => $e->getMessage()]);
                continue;

            } catch (\RuntimeException $e) {
                $hasErrors = true;
                Log::error('InsertTeams Runtime Error', ['error' => $e->getMessage()]);
                continue;

            }
        }
        return $hasErrors;
    }
}
