<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Package\PackageController;



Route::middleware(['auth'])->group(function () {

    Route::get('/packages', [PackageController::class, 'index'])->name('packages');
    Route::post('/update/or/create/package', [PackageController::class, 'storeOrUpdate'])->name('update-or-create-package');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/packages', [PackageController::class, 'destroy'])->name('delete-package');

});


