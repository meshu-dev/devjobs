<?php

use App\Http\Controllers\{
    AuthController,
    JobController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:web')->group(function ($router) {
    Route::get('/',           [JobController::class, 'list'])->name('job.list');
    Route::get('/favourites', [JobController::class, 'favourites'])->name('job.favourites');
    Route::get('/view/{job}', [JobController::class, 'view'])->name('job.view');
    Route::get('/profile',    [UserController::class, 'profile'])->name('user.profile');
});
