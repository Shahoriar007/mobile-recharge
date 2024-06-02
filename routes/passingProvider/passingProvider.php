<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassingProvider\PassingProviderController;


Route::middleware(['auth'])->group(function () {

    Route::get('/passing-to-provider', [PassingProviderController::class, 'index'])->name('passing-to-provider');
    Route::post('/update/or/create/passing-to-provider', [PassingProviderController::class, 'storeOrUpdate'])->name('update-or-create-passing-to-provider');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/passing-to-provider', [PassingProviderController::class, 'destroy'])->name('delete-passing-to-provider');

});





