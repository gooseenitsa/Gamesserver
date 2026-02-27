<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

// --- НАШИ ПУБЛИЧНЫЕ СТРАНИЦЫ ---
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/game/{game}', [CatalogController::class, 'show'])->name('game.show');

// --- ЛИЧНЫЙ КАБИНЕТ (Пока просто заглушка Breeze) ---
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// --- НАСТРОЙКИ ПРОФИЛЯ ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{tariff}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{cart}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
});

require __DIR__ . '/auth.php';