<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    // rotas privadas
    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::post('exercises', [ExerciseController::class, "store"]);
});

// rota pública
Route::post('users', [UserController::class, 'store']);
Route::post('login', [AuthController::class, 'store']);
