<?php

use Illuminate\Support\Facades\Route;
use Dotclang\AuthPackage\Http\Controllers\AuthController;

Route::middleware('web')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
