<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\TeamController;


Route::get('/competitions/{competitionId}/standings', [CompetitionController::class, 'getCurrentStandings']);

Route::get('/teams/{teamId}', [TeamController::class, 'show']);
