<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRemindTimeRequest;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $remindTime = $user->remind_time;
        $favoriteTeamIds = $user->favorites->pluck('team_id');
        $reminders = Game::getReminders($favoriteTeamIds);

        return response()->json([
            'reminders' => $reminders,
            'remindTime' => $remindTime,
        ], 200);
    }

    public function updateRemindTime(UpdateRemindTimeRequest $request)
    {
        $user = $request->user();
        $user->remind_time = $request->remindTime;
        $user->save();

        return response()->json(['message' => '通知時間を更新しました。'], 200);
    }
}
