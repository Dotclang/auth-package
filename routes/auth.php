<?php

use Illuminate\Support\Facades\Route;
use Dotclang\AuthPackage\Http\Controllers\AuthController;

Route::middleware('web')->prefix('auth')->name('auth.')->group(function () {
    // Authentication
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.attempt');

    // Password reset
    Route::get('password/reset', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('throttle:6,1');
    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

    // Confirm password (requires auth)
    Route::get('password/confirm', [AuthController::class, 'showConfirmPassword'])->name('password.confirm')->middleware('auth');
    Route::post('password/confirm', [AuthController::class, 'confirmPassword'])->name('password.confirm.post')->middleware('auth');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Compatibility: redirect common unprefixed routes to package-prefixed routes
Route::middleware('web')->group(function () {
    Route::get('login', fn () => redirect()->route('auth.login'))->name('login');
    Route::get('register', fn () => redirect()->route('auth.register'))->name('register');

    Route::get('password/reset', fn () => redirect()->route('auth.password.request'))->name('password.request');
    Route::get('password/reset/{token}', function ($token) { return redirect()->route('auth.password.reset', $token); })->name('password.reset');
    Route::get('password/confirm', fn () => redirect()->route('auth.password.confirm'))->name('password.confirm');
});
