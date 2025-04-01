<?php

use App\Http\Controllers\MarkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/weather', [\App\Http\Controllers\WeatherController::class, 'index'])->name('weather');

Route::resource('markers', MarkerController::class);