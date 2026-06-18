<?php

use App\Enums\JobEnum;
use App\Enums\UserEnum;
use App\Models\Job;
use App\Models\User;
use Livewire\Livewire;

describe('JobsFavourites tests', function () {
    it('renders jobs favourites', function () {

        $user = User::find(UserEnum::MAIN->value);

        $softwareEngineerJob = Job::find(JobEnum::LARAVEL_DEVELOPER->value);

        Livewire::actingAs($user)
            ->test('pages::jobs.favourites')
            ->assertSee('Favourites')
            ->assertSee($softwareEngineerJob->title);
    });
});
