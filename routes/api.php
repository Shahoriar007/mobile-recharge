<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Blog api routes
require __DIR__ . '/blogs/apiBlogs.php';
require __DIR__ . '/queries/apiQueries.php';
require __DIR__ . '/subscription/apiSubscription.php';
require __DIR__ . '/contacts/apiContacts.php';

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


