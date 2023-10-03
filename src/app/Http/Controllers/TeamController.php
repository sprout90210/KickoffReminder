<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{

    public function show($teamId){

        $team = Team::find($teamId);

        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        return response()->json($team);
    }

    public function getStandings($teamId){

        $standings = Team::getStandings($teamId);

        if (!$standings) {
            return response()->json(['message' => 'Team standings not found'], 404);
        }

        return response()->json($standings, 200);
    }

    public function getResults($teamId){

        $results = Team::getResults($teamId);

        if (!$results) {
            return response()->json(['message' => 'Team Results not found'], 404);
        }

        return response()->json($results, 200);
    }

    public function getSchedules($teamId){

        $schedules = Team::getSchedules($teamId);

        if (!$schedules) {
            return response()->json(['message' => 'Team schedules not found'], 404);
        }

        return response()->json($schedules, 200);
    }


    public function getNextGame($teamId){

        $nextGame = Team::getNextGame($teamId);

        if (!$nextGame) {
            return response()->json(['message' => 'Team next game not found'], 404);
        }

        return response()->json($nextGame, 200);
    }
}
