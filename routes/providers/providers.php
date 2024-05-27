<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Provider\ProviderController;


Route::middleware(['auth'])->group(function () {

    Route::get('/providers', [ProviderController::class, 'index'])->name('providers');
    // Route::post('/users', [UserController::class, 'store'])->name('create-user');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    // Route::delete('/users', [UserController::class, 'destroy'])->name('delete-user');

});


