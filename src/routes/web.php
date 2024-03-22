<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LineLoginController;
use Illuminate\Support\Facades\Route;

Route::get('line/login', [LineLoginController::class, 'redirectToLine']);
Route::get('line/login/callback', [LineLoginController::class, 'handleLineCallback']);
Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verify']);

Route::get('{any}', function () {
    return view('index');
})->where('any', '.*');
