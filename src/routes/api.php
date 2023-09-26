<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\TeamController;


Route::get('/competitions/{competitionId}/standings', [CompetitionController::class, 'getCurrentStandings']);

Route::get('/teams/{teamId}', [TeamController::class, 'show']);
Route::get('/teams/{teamId}/standings', [TeamController::class, 'getTeamStandings']);
Route::get('/teams/{teamId}/recentGames', [TeamController::class, 'getTeamRecentGames']);
Route::get('/teams/{teamId}/results', [TeamController::class, 'getTeamResults']);
Route::get('/teams/{teamId}/schedule', [TeamController::class, 'getTeamSchedule']);
