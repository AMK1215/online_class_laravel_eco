<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductStatusController;
use App\Http\Controllers\Admin\ProductController;

Route::group([
    'prefix' => 'admin', 'as' => 'admin.',
    'middleware' => ['auth', 'checkBanned'],
], function () {
    // Admin dashboard
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Admin logout
    Route::post('logout', [\App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('logout');
    
    Route::resource('players', PlayerController::class); // admin/players

    // index, create, edit, show, store, update, destroy
    Route::post('players/{id}/reset-password', [PlayerController::class, 'resetPassword'])->name('players.reset-password');
    Route::post('players/{id}/toggle-status', [PlayerController::class, 'banUser'])->name('players.toggle-status');
    Route::get('players/{id}/change-password', [PlayerController::class, 'resetPwdForm'])->name('players.change-password');
    Route::post('players/{id}/change-password', [PlayerController::class, 'makeChangePassword'])->name('players.makechange-password');
    
    // Profile routes
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Vendor routes
    Route::resource('vendors', VendorController::class);
    Route::post('vendors/{id}/toggle-status', [VendorController::class, 'toggleStatus'])->name('vendors.toggle-status');
    Route::get('vendors/{id}/reviews', [VendorController::class, 'reviews'])->name('vendors.reviews');
    Route::get('vendors/{id}/payments', [VendorController::class, 'payments'])->name('vendors.payments');
    Route::get('vendors/{id}/settings', [VendorController::class, 'settings'])->name('vendors.settings');

    // Product Category routes
    Route::resource('product-categories', ProductCategoryController::class);

    // Product Status routes
    Route::resource('product-statuses', ProductStatusController::class);

    // Product routes
    Route::resource('products', ProductController::class);
    Route::post('products/{id}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/{id}/update-quantity', [ProductController::class, 'updateQuantity'])->name('products.update-quantity');
});
