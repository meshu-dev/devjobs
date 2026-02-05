<?php

use App\Http\Controllers\{
    AuthController,
    JobController,
    ProfileController
};
use Illuminate\Support\Facades\Route;

Route::get('/login',       [AuthController::class, 'index'])->name('login');
Route::post('/login',      [AuthController::class, 'userLogin']);
Route::post('/login/demo', [AuthController::class, 'demoLogin']);

Route::middleware('auth:web')->group(function ($router) {
    Route::get('/',           [JobController::class, 'list'])->name('job.list');
    Route::get('/favourites', [JobController::class, 'favourites']);
    Route::get('/view/{job}', [JobController::class, 'view']);
    Route::get('/profile',    [ProfileController::class, 'view'])->name('profile.view');
    Route::post('/profile',   [ProfileController::class, 'edit']);
    Route::post('/logout',    [AuthController::class, 'logout']);
});
