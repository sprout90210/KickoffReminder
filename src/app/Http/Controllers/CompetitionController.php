<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;

class CompetitionController extends Controller
{
    public function getCurrentStandings($competitionId){

        $standings = Competition::getCurrentStandings($competitionId);

        return  response()->json($standings);
    }
}
