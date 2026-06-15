<?php

use Livewire\Livewire;

describe('Header tests', function () {
    it('renders header component with title', function () {
        $title = 'Job Listings';

        Livewire::test('header', ['title' => $title])
            ->assertSee($title);
    });
});
