<?php

use Dotclang\AuthPackage\Http\Controllers\Auth\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Top-level dashboard: show package dashboard (protected by auth)
Route::middleware(['web', 'auth'])->get('dashboard', DashboardController::class)->name('dashboard');

require __DIR__.'/auth.php';
