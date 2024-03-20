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
    Route::get('/blog', [BlogController::class, 'index'])->name('blog'); //blog list
    Route::get('/blog/create', [BlogController::class, 'createBLogView'])->name('create-blog'); //blog create view
    Route::post('/blog/post', [BlogController::class, 'storeBlog'])->name('store-blog'); //blog create
    Route::match(['put', 'get'], '/blog/update/{id}', [BlogController::class, 'createContentView'])->name('update-blog');//content view
    Route::post('/blog/content', [BlogController::class, 'storeContent'])->name('create-content'); //blog content create
    Route::match(['put', 'get'], '/blog/seo/{id}', [BlogController::class, 'createSeoView'])->name('seo-blog');//seo view
    Route::post('/blog/seo', [BlogController::class, 'storeSeo'])->name('store-seo'); //blog content create





    Route::get('/blog/seo', [BlogController::class, 'updateSeoView'])->name('update-seo');
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('edit-blog');
    Route::put('/blog/{id}', [BlogController::class, 'update'])->name('update-blog');
    Route::delete('/blog', [BlogController::class, 'destroy'])->name('delete-blog');
    Route::get('/blog/{id}/view', [BlogController::class, 'view'])->name('view-blog');






});
