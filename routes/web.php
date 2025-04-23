<?php

use App\Http\Controllers\AircraftController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PaymentController;
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


# Shop

Route::resource('shop', ShopController::class);

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::post('checkout/create', [PaymentController::class, 'createCheckoutSession'])->name('checkout.create');
Route::get('checkout/success', [PaymentController::class, 'success'])->name('checkout.success');
Route::get('checkout/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel');

# Aircraft API

Route::resource('aircraft', AircraftController::class);