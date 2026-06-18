<?php

//Route::livewire('/', 'pages::users.index');

Route::livewire('/login', 'pages::auth.login')->name('login');

Route::middleware(['auth:web'])->group(function () {
    Route::livewire('/',           'pages::jobs.jobs-list');
    Route::livewire('/view/{id}',  'pages::jobs.view');
    Route::livewire('/favourites', 'pages::jobs.favourites');
    Route::livewire('/profile',    'pages::user.profile');
    Route::livewire('/logs',       'pages::user.logs');
    Route::livewire('/logout',     'pages::auth.logout');

    Route::livewire('/hello',                      'pages::users.index');
});
