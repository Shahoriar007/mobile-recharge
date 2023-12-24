<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\BlogCategoryController;


Route::middleware(['auth'])->group(function () {

    // blog category resource route
    Route::get('/blog-category', [BlogCategoryController::class, 'index'])->name('blog-category');
    Route::post('/blog-category', [BlogCategoryController::class, 'store'])->name('create-blog-category');
    Route::get('/blog-category/{id}/edit', [BlogCategoryController::class, 'edit'])->name('edit-blog-category');
    // Route::put('/blog-category/{id}', [BlogCategoryController::class, 'update'])->name('update-user');
    Route::delete('/blog-category', [BlogCategoryController::class, 'destroy'])->name('delete-blog-category');


    // blog routes
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('create-blog');
    Route::post('/blog', [BlogController::class, 'store'])->name('store-blog');
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('edit-blog');
    Route::put('/blog/{id}', [BlogController::class, 'update'])->name('update-blog');
    Route::delete('/blog', [BlogController::class, 'destroy'])->name('delete-blog');
    Route::get('/blog/{id}/view', [BlogController::class, 'view'])->name('view-blog');






});
