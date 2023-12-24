<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthenticationController;

//Admin Panel login logout routes
require __DIR__ . '/auth/auth.php';

//Admin Panel users routes
require __DIR__ . '/users/users.php';

//Blog routes
require __DIR__ . '/blogs/blogs.php';



Route::middleware(['auth'])->group(function () {

Route::get('/', [StaterkitController::class, 'home'])->name('admin-home');

});



