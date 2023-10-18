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
            return response()->json(['message' => 'competition not found'], 404);
        }

        return  response()->json($competition, 200);
    }


    public function getCurrentStandings($competitionId)
    {
        $standings = Competition::getCurrentStandings($competitionId);

        if (!$standings) {
            return response()->json(['message' => 'Current standings not found'], 404);
        }

        return  response()->json($standings, 200);
    }


    public function getResults($competitionId){

        $results = Competition::getResults($competitionId);

        if (!$results) {
            return response()->json(['message' => 'Competition Results not found'], 404);
        }

        return response()->json($results, 200);
    }


    public function getSchedules($competitionId){

        $schedules = Competition::getSchedules($competitionId);

        if (!$schedules) {
            return response()->json(['message' => 'Competition schedules not found'], 404);
        }

        return response()->json($schedules, 200);
    }
}
