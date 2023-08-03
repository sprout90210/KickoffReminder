<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;



Route::get('/teams/{teamId}', [TeamController::class, 'show']);
