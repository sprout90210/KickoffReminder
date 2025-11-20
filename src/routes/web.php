<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LineLoginController;
use App\Http\Controllers\CompetitionCsvController;
use Illuminate\Support\Facades\Route;

Route::prefix('competitions/upload')->group(function () {
    Route::get('/', [CompetitionCsvController::class, 'showForm'])->name('competitions.upload.form');
    Route::post('/', [CompetitionCsvController::class, 'upload'])->name('competitions.upload');
});

Route::get('line/login', [LineLoginController::class, 'redirectToLine']);
Route::get('line/login/callback', [LineLoginController::class, 'handleLineCallback']);
Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verify']);

Route::get('{any}', function () {
    return view('index');
})->where('any', '.*');
