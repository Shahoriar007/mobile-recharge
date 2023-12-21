<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\BlogCategoryController;

// blog category api routes
Route::get('/blog-category', [BlogCategoryController::class, 'apiIndex']);
Route::get('/blog-category/{id}', [BlogCategoryController::class, 'apiShow']);
// blogs api routes
Route::get('/blog', [BlogController::class, 'apiIndex']);
Route::get('/blog/{id}', [BlogController::class, 'apiShow']);
