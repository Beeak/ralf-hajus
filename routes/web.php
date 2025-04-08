<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

# Weather thing

Route::get('/weather', [WeatherController::class, 'index'])->name('weather');

# Map marker thing

Route::resource('markers', MarkerController::class);

# Blog 

Route::resource('blog', BlogController::class)
->only(['create', 'store', 'edit', 'update', 'destroy'])
->middleware('auth');

Route::resource('blog', BlogController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

Route::middleware('auth')->group(function () {
    Route::resource('blog.comments', CommentController::class)
        ->only(['store', 'edit', 'update', 'destroy']);
});