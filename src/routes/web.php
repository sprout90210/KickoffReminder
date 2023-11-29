<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LineLoginController;


Route::get('line/login', [LineLoginController::class, 'redirectToLine']);
Route::get('line/login/callback', [LineLoginController::class, 'handleLineCallback']);

Route::get('{any}', function () {
    return view('index');
})->where('any', '.*');
