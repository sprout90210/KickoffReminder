<?php

namespace App\Http\Controllers;

use App\Models\Game;

class GameController extends Controller
{
    public function getUpcomingGames()
    {
        $upcomingGames = Game::whereIn('status', ['IN_PLAY', 'TIMED'])
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->orderBy('utc_date', 'asc')
            ->limit(20)
            ->get();

        return response()->json($upcomingGames, 200);
    }
}
