<?php

use App\Models\User;
use Livewire\Livewire;
use App\Enums\UserEnum;

describe('User - profile page tests', function () {
    beforeEach(function() {
        $this->user = User::find(UserEnum::MAIN->value);
    });

    it('renders user profile page', function () {
        Livewire::actingAs($this->user)
            ->test('pages::user.profile')
            ->assertSet('name', $this->user->name)
            ->assertSet('minSalary', $this->user->profile->min_salary)
            ->assertSet('maxSalary', $this->user->profile->max_salary);

        $this->assertAuthenticated();
    });

    it('updates user profile', function () {
        $name = 'Joe Bloggs';
        $minSalary = 20000;
        $maxSalary = 40000;

        Livewire::actingAs($this->user)
            ->test('pages::user.profile')
            ->set('name', $name)
            ->set('minSalary', 20000)
            ->set('maxSalary', 40000)
            ->call('save');

        $this->assertAuthenticated();

        $this->user->refresh();

        expect($this->user->name)
            ->toBe($name)
            ->and($this->user->profile->min_salary)
            ->toBe($minSalary)
            ->and($this->user->profile->max_salary)
            ->toBe($maxSalary);
    });
});
