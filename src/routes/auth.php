<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::post('email/verify', [EmailVerificationController::class, 'sendVerificationEmail']);
Route::post('register', [UserController::class, 'store']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('check', [LoginController::class, 'check']);

Route::prefix('password')->group(function () {
    Route::post('forgot', [PasswordController::class, 'sendResetLink']);
    Route::post('reset', [PasswordController::class, 'reset']);
    Route::put('/', [PasswordController::class, 'update'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::put('user', [UserController::class, 'update']);
    Route::delete('user', [UserController::class, 'destroy']);
});