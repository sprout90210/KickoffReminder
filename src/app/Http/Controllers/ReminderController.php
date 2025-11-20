<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReceiveReminderRequest;
use App\Http\Requests\UpdateRemindTimeRequest;
use App\Models\Game;
use App\Services\{UserService, GameService};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    private UserService $userService;
    private GameService $gameService;

    public function __construct(UserService $userService, GameService $gameService)
    {
        $this->userService = $userService;
        $this->gameService = $gameService;
    }

    public function index(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $favoriteTeamIds = $this->userService->getFavoriteTeamIds($user);
        $reminders = $this->gameService->getReminders($favoriteTeamIds);

        return response()->json([
            'receiveReminder' => $user->receive_reminder,
            'remindTime' => $user->remind_time,
            'reminders' => $reminders,
        ], 200);
    }

    public function updateReceiveReminder(UpdateReceiveReminderRequest $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user->receive_reminder = $request->receiveReminder;
        $user->save();

        return response()->json(null, 200);
    }

    public function updateRemindTime(UpdateRemindTimeRequest $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user->remind_time = $request->remindTime;
        $user->save();

        return response()->json(null, 200);
    }
}
