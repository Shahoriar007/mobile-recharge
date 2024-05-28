<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Terminal\TerminalController;


Route::middleware(['auth'])->group(function () {

    Route::get('/terminals', [TerminalController::class, 'index'])->name('terminals');
    Route::post('/update/or/create/terminal', [TerminalController::class, 'storeOrUpdate'])->name('update-or-create-terminal');
    // Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
    // Route::put('/users/{user}', [UserController::class, 'update'])->name('update-user');
    // Route::delete('/users', [UserController::class, 'destroy'])->name('delete-user');

});


