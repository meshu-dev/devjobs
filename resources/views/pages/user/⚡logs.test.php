<?php

use App\Models\User;
use Livewire\Livewire;
use App\Enums\UserEnum;

describe('User - logs page tests', function () {
    it('renders user logs page', function () {
        $user = User::find(UserEnum::MAIN->value);

        Livewire::actingAs($user)->test('pages::user.logs');

        $this->assertAuthenticated();
    });
});
