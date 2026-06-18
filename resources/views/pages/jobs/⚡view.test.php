<?php

use App\Enums\JobEnum;
use App\Models\User;
use Livewire\Livewire;
use App\Enums\UserEnum;
use App\Models\Job;

describe('Jobs - view page tests', function () {
    beforeEach(function() {
        $this->job = Job::find(JobEnum::SOFTWARE_ENGINEER->value);
    });

    it('renders jobs view page', function () {
        $user = User::find(UserEnum::MAIN->value);

        Livewire::actingAs($user)
            ->test('pages::jobs.view', ['id' => $this->job->id]);

        $this->assertAuthenticated();
    });

    it('marks a job as favourited', function () {
        $user = User::find(UserEnum::MAIN->value);

        Livewire::actingAs($user)
            ->test('pages::jobs.view', ['id' => $this->job->id])
            ->assertSee('Favourite')
            ->assertDontSee('Unfavourite')
            ->call('toggleFavourite')
            ->assertSee('Unfavourite');

        $this->assertAuthenticated();
    });
});
