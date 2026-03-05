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
    // Управление серверами в ЛК
    Route::post('/dashboard/server/{server}/toggle', [\App\Http\Controllers\DashboardController::class, 'toggle'])->name('server.toggle');
    Route::post('/dashboard/server/{server}/delete', [\App\Http\Controllers\DashboardController::class, 'destroy'])->name('server.destroy');
    // --- АДМИН ПАНЕЛЬ ---
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/server/{server}/toggle', [\App\Http\Controllers\AdminController::class, 'toggle'])->name('admin.server.toggle');
    Route::post('/admin/server/{server}/delete', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.server.destroy');

    // Добавление игр, тарифов и серверов из админки
    Route::post('/admin/game', [\App\Http\Controllers\AdminController::class, 'storeGame'])->name('admin.game.store');
    Route::post('/admin/tariff', [\App\Http\Controllers\AdminController::class, 'storeTariff'])->name('admin.tariff.store');
    Route::post('/admin/server', [\App\Http\Controllers\AdminController::class, 'storeServer'])->name('admin.server.store');

    Route::post('/game/{game}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
    Route::post('/server/{server}/review', [\App\Http\Controllers\ReviewController::class, 'storeForServer'])->name('server.review.store');

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{tariff}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{cart}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{cart}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
});

require __DIR__ . '/auth.php';