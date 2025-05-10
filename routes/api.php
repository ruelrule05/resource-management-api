<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\JwtAuthMiddleware;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;

Route::middleware([JwtAuthMiddleware::class, 'throttle:60,1'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::apiResource('projects', ProjectController::class);
});

Route::middleware([AdminMiddleware::class, JwtAuthMiddleware::class, 'throttle:60,1'])->group(function () {
    Route::get('sample', function() {
        dd('hello there admin!');
    });

    Route::get('dashboard/metrics', [DashboardController::class, 'index']);
    Route::get('dashboard/projects-by-month', [DashboardController::class, 'projectsByMonth']);
});

Route::post('/contact', [ContactController::class, 'store']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);