<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/', [JobController::class, 'index'])->name('job.index');
Route::get('/view/{job}', [JobController::class, 'view'])->name('job.view');
