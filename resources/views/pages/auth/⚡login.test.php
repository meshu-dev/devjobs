<?php

use App\Models\User;
use Livewire\Livewire;

describe('Auth - login page tests', function () {
    it('logs the user in and redirects to the home page', function () {
        $user = User::factory()->create(['password' => 'secret-password']);

        Livewire::test('pages::auth.login')
            ->set('email', $user->email)
            ->set('password', 'secret-password')
            ->call('userLogin')
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    });

    it('does not log the user in with the wrong password', function () {
        $user = User::factory()->create(['password' => 'secret-password']);

        Livewire::test('pages::auth.login')
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('userLogin');

        $this->assertGuest();
    });
});
