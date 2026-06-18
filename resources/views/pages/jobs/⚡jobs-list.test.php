<?php

use App\Enums\JobEnum;
use App\Enums\UserEnum;
use App\Models\Job;
use App\Models\User;
use Livewire\Livewire;

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
