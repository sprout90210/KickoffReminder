<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserController::class, 'store']);

Route::get('check', [LoginController::class, 'check']);
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::prefix('password')->group(function () {
    Route::post('forgot', [PasswordController::class, 'sendResetLink']);
    Route::post('reset', [PasswordController::class, 'reset']);
    Route::put('update', [PasswordController::class, 'update'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::put('user', [UserController::class, 'update']);
    Route::delete('user', [UserController::class, 'destroy']);
});
