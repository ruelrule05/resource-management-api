<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\JwtAuthMiddleware;

Route::middleware([JwtAuthMiddleware::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('sample', function() {
        dd('hello there admin!');
    });
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);