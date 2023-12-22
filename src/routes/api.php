<?php

use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('teams/{teamId}')->group(function () {
    Route::get('/', [TeamController::class, 'show']);
    Route::get('standings', [TeamController::class, 'getStandings']);
    Route::get('results', [TeamController::class, 'getResults']);
    Route::get('schedules', [TeamController::class, 'getSchedules']);
    Route::get('nextGame', [TeamController::class, 'getNextGame']);
});

Route::prefix('competitions/{competitionId}')->group(function () {
    Route::get('/', [CompetitionController::class, 'show']);
    Route::get('standings', [CompetitionController::class, 'getCurrentStandings']);
    Route::get('results', [CompetitionController::class, 'getResults']);
    Route::get('schedules', [CompetitionController::class, 'getSchedules']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::get('reminders', [ReminderController::class, 'index']);
    Route::get('favorites', [FavoriteController::class, 'index']);
    Route::post('favorites', [FavoriteController::class, 'store']);
    Route::delete('favorites/{team_id}', [FavoriteController::class, 'destroy']);
    Route::put('update-remind-time', [ReminderController::class, 'updateRemindTime']);
});

Route::get('upcoming-games', [GameController::class, 'getUpcomingGames']);
Route::post('contact', [ContactController::class, 'send']);

require __DIR__.'/auth.php';
