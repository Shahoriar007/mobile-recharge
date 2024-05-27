<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;



Route::middleware(['auth'])->group(function () {

    Route::get('/products', [ProductController::class, 'index'])->name('products');
    // Route::post('/users', [UserController::class, 'store'])->name('create-user');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    // Route::delete('/users', [UserController::class, 'destroy'])->name('delete-user');

});


