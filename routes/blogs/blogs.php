<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\BlogCategoryController;


Route::middleware(['auth'])->prefix('admin')->group(function () {

// blog category resource route
Route::resource('blog-category', BlogCategoryController::class);

});
