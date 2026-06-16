<?php

use App\Enums\JobEnum;
use App\Models\User;
use Livewire\Livewire;
use App\Enums\UserEnum;
use App\Models\Job;

describe('JobsList tests', function () {
    it('renders jobs list', function () {
        $user = User::find(UserEnum::MAIN->value);

        $softwareEngineerJob = Job::find(JobEnum::SOFTWARE_ENGINEER->value);

        Livewire::actingAs($user)
            ->test('pages::jobs.jobs-list')
            ->assertSee('Jobs')
            ->assertSee($softwareEngineerJob->title);
    });
});
