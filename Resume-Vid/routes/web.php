<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('videos', VideoController::class);
    Route::post('/videos/{video}/summarize', [VideoController::class, 'summarize'])->name('videos.summarize');
    Route::get('/proxy-download/{fileId}', [VideoController::class, 'proxyDownload']);

});

require __DIR__.'/auth.php';
