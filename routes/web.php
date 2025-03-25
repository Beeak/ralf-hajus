<?php

use App\Http\Controllers\MarkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/map', [MarkerController::class, 'index'])->name('markers.index');
Route::resource('markers', MarkerController::class);