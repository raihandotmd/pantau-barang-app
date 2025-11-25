<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\CheckStoreStatus;
use App\Http\Middleware\IsSuperAdmin;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'has.store', CheckStoreStatus::class])
    ->name('dashboard');

Route::middleware(['auth', 'has.store', 'verify.store'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Store routes - only need has.store, not verify.store (creating new store)
    Route::middleware(['auth', 'has.store'])->group(function () {
        Route::get('/store/create', [StoreController::class, 'create'])->name('store.create')->withoutMiddleware(['has.store', 'verify.store']);
        Route::post('/store', [StoreController::class, 'store'])->name('store.store')->withoutMiddleware(['has.store', 'verify.store']);
        Route::post('/store/generate-slug', [StoreController::class, 'generateSlug'])->name('store.generate-slug')->withoutMiddleware(['has.store', 'verify.store']);
        
        // Pending route
        Route::get('/store/pending', [StoreController::class, 'pending'])->name('store.pending')->withoutMiddleware(['verify.store']);
    });

    // Category routes
    Route::resource('categories', CategoryController::class)->middleware(CheckStoreStatus::class);

    // Item routes
    Route::resource('items', ItemController::class)->middleware(CheckStoreStatus::class);

    // Order routes (Admin)
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index')->middleware(CheckStoreStatus::class);
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show')->middleware(CheckStoreStatus::class);
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status')->middleware(CheckStoreStatus::class);

    // Store Profile routes
    Route::get('/store/profile', [\App\Http\Controllers\StoreProfileController::class, 'edit'])->name('store-profile.edit')->middleware(CheckStoreStatus::class);
    Route::patch('/store/profile', [\App\Http\Controllers\StoreProfileController::class, 'update'])->name('store-profile.update')->middleware(CheckStoreStatus::class);

    // Stock Movement routes
    Route::resource('stock-movements', StockMovementController::class)->only(['index', 'create', 'store', 'show'])->middleware(CheckStoreStatus::class);
});

// Super Admin Routes
Route::middleware(['auth', IsSuperAdmin::class])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stores', [\App\Http\Controllers\SuperAdmin\StoreController::class, 'index'])->name('stores.index');
    Route::patch('/stores/{store}/approve', [\App\Http\Controllers\SuperAdmin\StoreController::class, 'approve'])->name('stores.approve');
    Route::patch('/stores/{store}/reject', [\App\Http\Controllers\SuperAdmin\StoreController::class, 'reject'])->name('stores.reject');
});

// Frontend Routes (Public)
Route::get('/catalog', [\App\Http\Controllers\Front\CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{item}', [\App\Http\Controllers\Front\CatalogController::class, 'show'])->name('catalog.show');

Route::get('/cart', [\App\Http\Controllers\Front\CheckoutController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{item}', [\App\Http\Controllers\Front\CheckoutController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove', [\App\Http\Controllers\Front\CheckoutController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [\App\Http\Controllers\Front\CheckoutController::class, 'store'])->name('checkout.store');

require __DIR__ . '/auth.php';
