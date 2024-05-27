<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Provider\ProviderController;


Route::middleware(['auth'])->group(function () {

    Route::get('/providers', [ProviderController::class, 'index'])->name('providers');
    Route::post('/update/or/create/provider', [ProviderController::class, 'storeOrUpdate'])->name('update-or-create-provider');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    // Route::delete('/users', [UserController::class, 'destroy'])->name('delete-user');

});


