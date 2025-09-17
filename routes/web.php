<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require_once __DIR__.'/admin.php';

// Admin login routes (existing)
Route::get('admin/login', [LoginController::class, 'ShowloginForm'])->name('admin.show-login-form');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.login');

Auth::Routes();

// User authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserAuthController::class, 'login'])->name('user.login');
    Route::get('register', [UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [UserAuthController::class, 'register'])->name('user.register');
    Route::get('forgot-password', [UserAuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [UserAuthController::class, 'sendResetLinkEmail'])->name('password.email');
});

// Logout route (accessible to authenticated users)
Route::middleware('auth')->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
});

// User dashboard route (protected)
Route::middleware('auth')->group(function () {
    Route::get('user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('welcome', function(){
    return view('welcome');
});

// User Product routes
Route::get('products', [\App\Http\Controllers\UserProductController::class, 'index'])->name('products.index');
Route::get('products/search', [\App\Http\Controllers\UserProductController::class, 'search'])->name('products.search');
Route::get('products/{id}', [\App\Http\Controllers\UserProductController::class, 'show'])->name('products.show');
Route::get('category/{id}/products', [\App\Http\Controllers\UserProductController::class, 'byCategory'])->name('products.by-category');
Route::get('vendor/{id}/products', [\App\Http\Controllers\UserProductController::class, 'byVendor'])->name('products.by-vendor');
