<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Contact\ContactController;


Route::middleware(['auth'])->group(function () {
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');



});
