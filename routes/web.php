<?php

use App\Http\Controllers\{
    AuthController,
    HomeController,
    JobController
};
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:web')->group(function ($router) {
    //Route::get('/secret', [HomeController::class, 'index'])->name('secret.index');

    Route::get('/', [JobController::class, 'index'])->name('job.index');
    Route::get('/view/{job}', [JobController::class, 'view'])->name('job.view');
});
