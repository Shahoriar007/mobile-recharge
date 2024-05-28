<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Offer\OfferController;


Route::middleware(['auth'])->group(function () {

    Route::get('/offers', [OfferController::class, 'index'])->name('offers');
    Route::post('/update/or/create/offer', [OfferController::class, 'storeOrUpdate'])->name('update-or-create-offer');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    // Route::delete('/users', [UserController::class, 'destroy'])->name('delete-user');

});
