<?php

namespace App\Http\Controllers;

use App\Models\Team;

class TeamController extends Controller
{
    public function show($teamId)
    {
        $team = Team::find($teamId);

        if (! $team) {
            return response()->json(['message' => 'データが見つかりませんでした。'], 404);
        }

        return response()->json($team, 200);
    }

    public function getStandings($teamId)
    {
        $standings = Team::getStandings($teamId);

        return response()->json($standings, 200);
    }

    public function getResults($teamId)
    {
        $results = Team::getResults($teamId);

        return response()->json($results, 200);
    }

    public function getSchedules($teamId)
    {
        $schedules = Team::getSchedules($teamId);

        return response()->json($schedules, 200);
    }

    public function getNextGame($teamId)
    {
        $nextGame = Team::getNextGame($teamId);

        if (! $nextGame) {
            return response()->json(['message' => 'データが見つかりませんでした。'], 404);
        }
        
        return response()->json($nextGame, 200);
    }
}
