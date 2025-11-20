<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Services\CompetitionService;
use Illuminate\Http\JsonResponse;

/**
 * 大会（Competition）データの取得を行うコントローラ.
 *
 * 大会の基本情報・順位情報・試合結果・日程などを返す API を提供する。
 */
class CompetitionController extends Controller
{
    /**
     * @var CompetitionService 大会関連ロジックを扱うサービス
     */
    private CompetitionService $competitionService;

    public function __construct(CompetitionService $competitionService)
    {
        $this->competitionService = $competitionService;
    }

    /**
     * 大会の基本情報を返す
     *
     * @param int $competitionId
     * @return JsonResponse
     *
     * @apiResponse 200 Competition
     * @apiResponse 404 {"error":"データが見つかりませんでした。"}
     */
    public function show(int $competitionId): JsonResponse
    {
        $competition = Competition::find($competitionId);

        if (!$competition) {
            return response()->json(['error' => 'データが見つかりませんでした。'], 404);
        }

        return response()->json($competition, 200);
    }

    /**
     * 大会の最新シーズンの順位表を返す
     *
     * @param int $competitionId
     * @return JsonResponse
     *
     * @apiResponse 200 list<Standing>
     */
    public function getCurrentStandings(int $competitionId): JsonResponse
    {
        $standings = $this->competitionService->getCurrentStandings($competitionId);
        return response()->json($standings, 200);
    }

    /**
     * 大会の過去の試合結果（FINISHED / IN_PLAY）を返す
     *
     * @param int $competitionId
     * @return JsonResponse
     *
     * @apiResponse 200 list<Game>
     */
    public function getResults(int $competitionId): JsonResponse
    {
        $results = $this->competitionService->getResults($competitionId);
        return response()->json($results, 200);
    }

    /**
     * 大会の予定試合（SCHEDULED / TIMED）を返す
     *
     * @param int $competitionId
     * @return JsonResponse
     *
     * @apiResponse 200 list<Game>
     */
    public function getSchedules(int $competitionId): JsonResponse
    {
        $schedules = $this->competitionService->getSchedules($competitionId);
        return response()->json($schedules, 200);
    }
}
