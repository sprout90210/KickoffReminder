<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;

/**
 * チームに関するデータ取得を行うコントローラ.
 *
 * チーム情報・順位・試合結果・日程・次の試合などを返す。
 */
class TeamController extends Controller
{
    /**
     * @var TeamService チーム関連のビジネスロジック
     */
    private TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * 指定されたチームの詳細情報を返す
     *
     * @param int $teamId
     * @return JsonResponse
     *
     * @apiResponse 200 {"id":1,"name":"TeamName", ...}
     * @apiResponse 404 {"error":"データが見つかりませんでした。"}
     */
    public function show(int $teamId): JsonResponse
    {
        $team = Team::find($teamId);

        // ↓ バグ修正：$team が NOTHING（null）なら 404
        if (!$team) {
            return response()->json(['error' => 'データが見つかりませんでした。'], 404);
        }

        return response()->json($team, 200);
    }

    /**
     * チームの順位情報を返す
     *
     * @param int $teamId
     * @return JsonResponse
     *
     * @apiResponse 200 list<Standing>
     */
    public function getStandings(int $teamId): JsonResponse
    {
        $standings = $this->teamService->getStandings($teamId);
        return response()->json($standings, 200);
    }

    /**
     * チームの過去の試合結果（FINISHED / IN_PLAY）を返す
     *
     * @param int $teamId
     * @return JsonResponse
     *
     * @apiResponse 200 list<Game>
     */
    public function getResults(int $teamId): JsonResponse
    {
        $results = $this->teamService->getResults($teamId);
        return response()->json($results, 200);
    }

    /**
     * 予定されている試合情報（SCHEDULED / TIMED）を返す
     *
     * @param int $teamId
     * @return JsonResponse
     *
     * @apiResponse 200 list<Game>
     */
    public function getSchedules(int $teamId): JsonResponse
    {
        $schedules = $this->teamService->getSchedules($teamId);
        return response()->json($schedules, 200);
    }

    /**
     * 次の試合（最も近い TIMED）を返す
     *
     * @param int $teamId
     * @return JsonResponse
     *
     * @apiResponse 200 Game
     * @apiResponse 404 {"error":"データが見つかりませんでした。"}
     */
    public function getNextGame(int $teamId): JsonResponse
    {
        $nextGame = $this->teamService->getNextGame($teamId);

        if (!$nextGame) {
            return response()->json(['error' => 'データが見つかりませんでした。'], 404);
        }

        return response()->json($nextGame, 200);
    }
}
