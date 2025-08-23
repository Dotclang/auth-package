<?php

use Dotclang\AuthPackage\Http\Controllers\Auth\ConfirmPasswordController;
use Dotclang\AuthPackage\Http\Controllers\Auth\LoginController;
use Dotclang\AuthPackage\Http\Controllers\Auth\LogoutController;
use Dotclang\AuthPackage\Http\Controllers\Auth\PasswordController;
use Dotclang\AuthPackage\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->prefix('auth')->name('auth.')->group(function () {
    // Authentication
    Route::get('login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.attempt');

    Route::get('register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.attempt');

    // Password reset
    Route::get('password/reset', [PasswordController::class, 'showForgotPassword'])->name('password.request');
    Route::post('password/email', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('throttle:6,1');
    Route::get('password/reset/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [PasswordController::class, 'resetPassword'])->name('password.update');

    // Confirm password (requires auth)
    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmPassword'])->name('password.confirm')->middleware('auth');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirmPassword'])->name('password.confirm.post')->middleware('auth');

    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');
});

// Compatibility: redirect common unprefixed routes to package-prefixed routes
Route::middleware('web')->group(function () {
    Route::get('login', fn () => redirect()->route('auth.login'))->name('login');
    Route::get('register', fn () => redirect()->route('auth.register'))->name('register');

    Route::get('password/reset', fn () => redirect()->route('auth.password.request'))->name('password.request');
    Route::get('password/reset/{token}', function ($token) {
        return redirect()->route('auth.password.reset', $token);
    })->name('password.reset');
    Route::get('password/confirm', fn () => redirect()->route('auth.password.confirm'))->name('password.confirm');
});
