<?php

use App\Http\Controllers\OgImage\OgImageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/og-images', [OgImageController::class, 'index'])->name('og-images');
    Route::delete('/og-images', [OgImageController::class, 'destroy'])->name('delete-og-images');
    Route::post('/og-images/store', [OgImageController::class, 'store'])->name('store-og-image');

});
