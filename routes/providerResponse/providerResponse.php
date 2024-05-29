<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProviderResponse\ProviderResponseController;


Route::middleware(['auth'])->group(function () {

    Route::get('/providerResponses', [ProviderResponseController::class, 'index'])->name('providerResponses');
    Route::post('/update/or/create/providerResponse', [ProviderResponseController::class, 'storeOrUpdate'])->name('update-or-create-providerResponse');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/providerResponses', [ProviderResponseController::class, 'destroy'])->name('delete-providerResponse');

});


