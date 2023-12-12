<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;


class CompetitionController extends Controller
{

    public function show($competitionId)
    {
        $competition = Competition::find($competitionId);

        if (!$competition) {
            return response()->json(['error' => 'competitionが取得出来ませんでした。'], 404);
        }

        return  response()->json($competition, 200);
    }


    public function getCurrentStandings($competitionId)
    {
        $standings = Competition::getCurrentStandings($competitionId);

        if (!$standings) {
            return response()->json(['error' => 'standingsが取得出来ませんでした。'], 404);
        }

        return  response()->json($standings, 200);
    }


    public function getResults($competitionId){

        $results = Competition::getResults($competitionId);

        if (!$results) {
            return response()->json(['error' => 'resultsが取得出来ませんでした。'], 404);
        }

        return response()->json($results, 200);
    }


    public function getSchedules($competitionId){

        $schedules = Competition::getSchedules($competitionId);

        if (!$schedules) {
            return response()->json(['error' => 'schedulesが取得出来ませんでした。'], 404);
        }

        return response()->json($schedules, 200);
    }
}
