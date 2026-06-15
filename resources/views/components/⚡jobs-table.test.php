<?php

use App\Enums\JobEnum;
use App\Models\User;
use Livewire\Livewire;
use App\Enums\UserEnum;
use App\Models\Job;

describe('JobsTable tests', function () {
    it('renders jobs table', function () {

        $user = User::find(UserEnum::MAIN->value);

        $softwareEngineerJob = Job::find(JobEnum::SOFTWARE_ENGINEER->value);

        Livewire::actingAs($user)
            ->test('jobs-table', ['type' => 'jobs'])
            ->assertSee($softwareEngineerJob->title);
    });
});
