<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassingProvider\PassingProviderController;


Route::middleware(['auth'])->group(function () {

    Route::get('/passingProvider', [PassingProviderController::class, 'index'])->name('passingProvider');
    Route::post('/update/or/create/passingProvider', [PassingProviderController::class, 'storeOrUpdate'])->name('update-or-create-passingProvider');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/passingProvider', [PassingProviderController::class, 'destroy'])->name('delete-passingProvider');

});





