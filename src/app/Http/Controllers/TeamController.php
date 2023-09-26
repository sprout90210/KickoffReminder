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


    public function getTeamStandings($teamId){

        $standings = Team::getTeamStandings($teamId);

        if (!$standings) {
            return response()->json(['message' => 'Team standings not found'], 404);
        }

        return response()->json($standings, 200);
    }


    public function getTeamRecentGames($teamId){

        $recentGames = Team::getTeamRecentGames($teamId);

        if (!$recentGames) {
            return response()->json(['message' => 'Team recent games not found'], 404);
        }

        return response()->json($recentGames, 200);
    }
}
