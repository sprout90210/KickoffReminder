<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $favoriteTeamIds = $user->favorites->pluck('team_id');

        $reminders = Game::with(['homeTeam', 'awayTeam', 'competition'])
            ->where(function ($query) use ($favoriteTeamIds) {
                $query->whereIn('home_team_id', $favoriteTeamIds)
                    ->orWhereIn('away_team_id', $favoriteTeamIds);
            })
            ->whereIn('status', ['SCHEDULED', 'TIMED'])
            ->orderBy('utc_date', 'asc')
            ->limit(30)
            ->get();

        if ($reminders->isEmpty()) {
            return response()->json(['error' => '通知リストに登録されていません。'], 404);
        }
        return response()->json($reminders, 200);
    }
}
