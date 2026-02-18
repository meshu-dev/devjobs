<?php

//Route::livewire('/', 'pages::users.index');

Route::livewire('/login', 'pages::auth.login')->name('login');

Route::middleware(['auth:web'])->group(function () {
    Route::livewire('/',                      'pages::jobs.list');
    Route::livewire('/favourites',            'pages::jobs.favourites');
    Route::livewire('/profile',               'pages::user.profile');
    //Route::livewire('/technologies',          'pages::cv.technologies');
    //Route::livewire('/skills',                'pages::cv.skills');
    //Route::livewire('/work-experiences',      'pages::cv.work-experiences');
    //Route::livewire('/work-experiences/new',  'pages::cv.work-experience');
    //Route::livewire('/work-experiences/{id}', 'pages::cv.work-experience');
    Route::livewire('/logout',                'pages::auth.logout');

    Route::livewire('/hello',                      'pages::users.index');
});
