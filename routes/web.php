<?php

use Dotclang\AuthPackage\Http\Controllers\Auth\DashboardController;
use Dotclang\AuthPackage\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('AuthPackage::welcome');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');
    // Profile page
    Route::get('profile', [ProfileController::class, 'show'])
        ->name('profile');
    // Profile update
    Route::put('profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});

require __DIR__.'/auth.php';
