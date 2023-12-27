<?php

namespace App\Http\Controllers;

use App\Models\Competition;

class CompetitionController extends Controller
{
    public function show($competitionId)
    {
        $competition = Competition::find($competitionId);

        if (! $competition) {
            return response()->json(['message' => 'データが見つかりませんでした。'], 404);
        }

        return response()->json($competition, 200);
    }

    public function getCurrentStandings($competitionId)
    {
        $standings = Competition::getCurrentStandings($competitionId);

        return response()->json($standings, 200);
    }

    public function getResults($competitionId)
    {
        $results = Competition::getResults($competitionId);

        return response()->json($results, 200);
    }

    public function getSchedules($competitionId)
    {
        $schedules = Competition::getSchedules($competitionId);

        return response()->json($schedules, 200);
    }
}
