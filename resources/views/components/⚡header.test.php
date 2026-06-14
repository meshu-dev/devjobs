<?php

use Livewire\Livewire;

it('renders successfully', function () {
    $title = 'Job Listings';

    Livewire::test('header')
        ->set('title', $title)
        ->assertSee($title);
});
