<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\Auth\AuthenticationController;

//Admin Panel login logout routes
require __DIR__ . '/auth/auth.php';

Route::middleware(['auth'])->prefix('admin')->group(function () {

Route::get('/', [StaterkitController::class, 'home'])->name('admin-home');

});
