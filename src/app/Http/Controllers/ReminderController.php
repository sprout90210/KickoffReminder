<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReceiveReminderRequest;
use App\Http\Requests\UpdateRemindTimeRequest;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favoriteTeamIds = $user->favorites->pluck('team_id');
        $reminders = Game::getReminders($favoriteTeamIds);

        return response()->json(['reminders' => $reminders], 200);
    }

    public function updateReceiveReminder(UpdateReceiveReminderRequest $request)
    {
        $user = $request->user();
        $user->receive_reminder = $request->receiveReminder;
        $user->save();

        return response(null, 200);
    }

    public function updateRemindTime(UpdateRemindTimeRequest $request)
    {
        $user = $request->user();
        $user->remind_time = $request->remindTime;
        $user->save();

        return response(null, 200);
    }
}
