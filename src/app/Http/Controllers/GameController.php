<?php

namespace App\Http\Controllers;

use App\Services\GameService;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    private GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function getUpcomingGames(): JsonResponse
    {
        $upcomingGames = $this->gameService->getUpcomingGames();
        return response()->json($upcomingGames, 200);
    }
}
