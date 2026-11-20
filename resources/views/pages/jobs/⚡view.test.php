<?php

use App\Enums\JobEnum;
use App\Enums\UserEnum;
use App\Models\Job;
use App\Models\User;
use Livewire\Livewire;

describe('Jobs - view page tests', function () {
    beforeEach(function () {
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
            ->assertSee('Add to favourites')
            ->assertDontSee('Remove from favourites')
            ->call('toggleFavourite')
            ->assertSee('Remove from favourites');

        $this->assertAuthenticated();
    });

    it('returns not found for a job that does not exist', function () {
        $user = User::find(UserEnum::MAIN->value);

        Livewire::actingAs($user)
            ->test('pages::jobs.view', ['id' => 'missing-job-id'])
            ->assertNotFound();
    });

    it("returns not found for another user's job", function () {
        $demoUser = User::find(UserEnum::DEMO->value);

        Livewire::actingAs($demoUser)
            ->test('pages::jobs.view', ['id' => $this->job->id])
            ->assertNotFound();
    });
});
