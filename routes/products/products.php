<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;



Route::middleware(['auth'])->group(function () {

    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/update/or/create/product', [ProductController::class, 'storeOrUpdate'])->name('update-or-create-product');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/products', [ProductController::class, 'destroy'])->name('delete-product');

});


