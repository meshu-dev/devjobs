<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', [JobController::class, 'index'])->name('job.index');
Route::get('/view/{job}', [JobController::class, 'view'])->name('job.view');
