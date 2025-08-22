<?php

use Dotclang\AuthPackage\Http\Controllers\AuthController;

\Illuminate\Support\Facades\Route::middleware('web')->group(function () {
    \Illuminate\Support\Facades\Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    \Illuminate\Support\Facades\Route::post('login', [AuthController::class, 'login']);
    \Illuminate\Support\Facades\Route::get('register', [AuthController::class, 'showRegister']);
    \Illuminate\Support\Facades\Route::post('register', [AuthController::class, 'register']);
    \Illuminate\Support\Facades\Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
