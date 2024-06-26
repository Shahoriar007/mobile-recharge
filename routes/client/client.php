<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::middleware(['auth'])->group(function () {

    Route::get('/chat', [ClientController::class, 'chat'])->name('chat');


});


