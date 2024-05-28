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

//OG images
require __DIR__ . '/og-images/ogImages.php';

//Queries routes
require __DIR__ . '/queries/queries.php';

//Contacts routes
require __DIR__ . '/contacts/contacts.php';

//providers routes
require __DIR__ . '/providers/providers.php';

//products routes
require __DIR__ . '/products/products.php';


//products routes
require __DIR__ . '/offers/offers.php';


Route::middleware(['auth'])->group(function () {

Route::get('/', [StaterkitController::class, 'home'])->name('admin-home');

});



