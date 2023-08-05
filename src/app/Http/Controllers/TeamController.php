<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function show($teamId){

        $team = Team::find($teamId);

        // チームが見つからない場合は、404エラーを返します
        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        return response()->json($team);

    }
}
