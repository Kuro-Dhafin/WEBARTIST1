<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Core Controllers
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Artist\OrderStatusController;
use App\Http\Controllers\Artist\ServiceController as ArtistServiceController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Public / Guest
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('services', [ServiceController::class, 'index'])->name('services.index');

// Buyer Routes
Route::middleware(['auth','role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {

    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('dashboard', [\App\Http\Controllers\Buyer\DashboardController::class, 'index'])->name('dashboard');

    Route::get('services', [ServiceController::class, 'index'])->name('services.index');

    Route::post('orders/{service}', [OrderController::class, 'store'])->name('orders.store');
    Route::delete('orders/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Authenticated Base
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Artist Routes
Route::middleware(['auth','verified','role:artist'])->prefix('artist')->name('artist.')->group(function () {

    // Dashboard
    Route::get('dashboard', [\App\Http\Controllers\Artist\DashboardController::class, 'index'])->name('dashboard');

    // Services CRUD
    Route::get('services', [ArtistServiceController::class, 'artistIndex'])->name('services.index');
    Route::get('services/create', [ArtistServiceController::class, 'create'])->name('services.create');
    Route::post('services', [ArtistServiceController::class, 'store'])->name('services.store');
    Route::get('services/{service}/edit', [ArtistServiceController::class, 'edit'])->name('services.edit');
    Route::put('services/{service}', [ArtistServiceController::class, 'update'])->name('services.update');
    Route::delete('services/{service}', [ArtistServiceController::class, 'destroy'])->name('services.destroy');

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::patch('{order}/accept', [OrderStatusController::class, 'accept'])->name('accept');
        Route::patch('{order}/reject', [OrderStatusController::class, 'reject'])->name('reject');
        Route::patch('{order}/complete', [OrderStatusController::class, 'complete'])->name('complete');
    });
});

// Admin Routes
Route::middleware(['auth','verified','role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('users/{user}/status', [AdminUserController::class, 'updateStatus'])->name('users.status');

    // Services
    Route::get('services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::post('services/{service}/approve', [AdminServiceController::class, 'approve'])->name('services.approve');
    Route::post('services/{service}/reject', [AdminServiceController::class, 'reject'])->name('services.reject');
    Route::patch('services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::patch('services/{service}', [AdminServiceController::class, 'update'])->name('services.update');

    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}/logs', [AdminOrderController::class, 'logs'])->name('orders.logs');
});

// Auth scaffolding
require __DIR__.'/auth.php';
