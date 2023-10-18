<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\TeamController;


Route::prefix('/teams/{teamId}')->group(function () {
    Route::get('/', [TeamController::class, 'show']);
    Route::get('/standings', [TeamController::class, 'getStandings']);
    Route::get('/results', [TeamController::class, 'getResults']);
    Route::get('/schedules', [TeamController::class, 'getSchedules']);
    Route::get('/nextGame', [TeamController::class, 'getNextGame']);
});

Route::prefix('/competitions/{competitionId}')->group(function () {
    Route::get('/', [CompetitionController::class, 'show']);
    Route::get('/standings', [CompetitionController::class, 'getCurrentStandings']);
    Route::get('/results', [CompetitionController::class, 'getResults']);
    Route::get('/schedules', [CompetitionController::class, 'getSchedules']);
});
