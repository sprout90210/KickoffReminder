<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\EmailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;


Route::post('register', [UserController::class, 'store']);

Route::post('login', [LoginController::class, 'login']);

Route::post('logout', [LoginController::class, 'logout']);

Route::get('check', [LoginController::class, 'check']);

Route::post('password/forgot', [PasswordResetLinkController::class, 'store']);

Route::post('password/reset', [NewPasswordController::class, 'store']);


Route::middleware('auth:sanctum')->group(function(){
    
    Route::get('user', [UserController::class, 'show']);

    Route::put('email', [EmailController::class, 'update']);

    Route::put('password', [PasswordController::class, 'update']);

    Route::delete('user', [UserController::class, 'destroy']);
});
