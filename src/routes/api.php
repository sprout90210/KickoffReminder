<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\TeamController;


Route::get('/competitions/{competitionId}/standings', [CompetitionController::class, 'getCurrentStandings']);

Route::get('/teams/{teamId}', [TeamController::class, 'show']);
Route::get('/teams/{teamId}/standings', [TeamController::class, 'getStandings']);
Route::get('/teams/{teamId}/results', [TeamController::class, 'getResults']);
Route::get('/teams/{teamId}/schedules', [TeamController::class, 'getSchedules']);
Route::get('/teams/{teamId}/nextGame', [TeamController::class, 'getNextGame']);
