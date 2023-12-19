<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticationController;

// Admin Panel Routes
Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('login', [AuthenticationController::class, 'loginConfirm'])->name('loginConfirm');
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
