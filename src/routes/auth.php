<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\EmailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\PasswordController;


Route::post('register', [UserController::class, 'store']);

Route::post('login', [LoginController::class, 'login']);

Route::post('logout', [LoginController::class, 'logout']);

Route::get('check', [LoginController::class, 'check']);

Route::post('password/forgot', [PasswordController::class, 'sendResetLink']);

Route::post('password/reset', [PasswordController::class, 'reset']);


Route::middleware('auth:sanctum')->group(function(){

    Route::put('user', [UserController::class, 'update']);
    Route::delete('user', [UserController::class, 'destroy']);
    Route::put('password', [PasswordController::class, 'update']);

});
