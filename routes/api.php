<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AircraftController;
use App\Http\Controllers\Api\AuthController;

Route::middleware(['throttle:4,1'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});


Route::middleware(['auth:sanctum', 'throttle:4,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // API route
    Route::apiResource('aircraft', AircraftController::class);
});