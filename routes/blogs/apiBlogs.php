<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\BlogController;


Route::get('/blog', [BlogController::class, 'apiIndex']);
Route::get('/blog/{id}', [BlogController::class, 'apiShow']);
