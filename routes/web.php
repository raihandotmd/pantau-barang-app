<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'has.store'])
    ->name('dashboard');

Route::middleware(['auth', 'has.store', 'verify.store'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Store routes - only need has.store, not verify.store (creating new store)
    Route::middleware(['auth', 'has.store'])->group(function () {
        Route::get('/store/create', [StoreController::class, 'create'])->name('store.create')->withoutMiddleware('has.store');
        Route::post('/store', [StoreController::class, 'store'])->name('store.store')->withoutMiddleware('has.store');
        Route::post('/store/generate-slug', [StoreController::class, 'generateSlug'])->name('store.generate-slug');
    });

    // Category routes
    Route::resource('categories', CategoryController::class);

    // Item routes
    Route::resource('items', ItemController::class);

    // Stock Movement routes
    Route::resource('stock-movements', StockMovementController::class)->only(['index', 'create', 'store', 'show']);
});

require __DIR__ . '/auth.php';
