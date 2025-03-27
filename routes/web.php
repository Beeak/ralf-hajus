<?php

use App\Http\Controllers\MarkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('markers', MarkerController::class);