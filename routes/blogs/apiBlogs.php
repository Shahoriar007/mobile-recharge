<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\BlogCategoryController;

// blog category api routes
Route::get('/blog-category', [BlogCategoryController::class, 'apiIndex']);
Route::get('/blog-category/{id}', [BlogCategoryController::class, 'apiShow']);
// blogs api routes
Route::middleware('throttle:600,1')->group(function () {
    Route::get('/blog', [BlogController::class, 'apiIndex']);
    Route::get('/blog/{slug}', [BlogController::class, 'apiShow']);
});
//all blogs api routes
Route::get('/all-blog-slugs', [BlogController::class, 'apiAllBlogSlugs']);

Route::post('/subscription', [BlogController::class, 'subscription']);
