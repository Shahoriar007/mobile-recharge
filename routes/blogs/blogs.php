<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\BlogCategoryController;


Route::middleware(['auth'])->prefix('admin')->group(function () {

// blog category resource route
//Route::resource('blog-category', BlogCategoryController::class);

    Route::get('/blog-category', [BlogCategoryController::class, 'index'])->name('blog-category');
    Route::post('/blog-category', [BlogCategoryController::class, 'store'])->name('create-blog-category');
    Route::get('/blog-category/{id}/edit', [BlogCategoryController::class, 'edit'])->name('edit-blog-category');
    // Route::put('/blog-category/{id}', [BlogCategoryController::class, 'update'])->name('update-user');
    Route::delete('/blog-category', [BlogCategoryController::class, 'destroy'])->name('delete-blog-category');

});
