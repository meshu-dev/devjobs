<?php

use App\Enums\JobEnum;
use App\Enums\UserEnum;
use App\Models\Job;
use App\Models\User;
use Livewire\Livewire;

describe('JobsTable tests', function () {
    it('renders jobs table', function () {

        $user = User::find(UserEnum::MAIN->value);

        $softwareEngineerJob = Job::find(JobEnum::SOFTWARE_ENGINEER->value);

        Livewire::actingAs($user)
            ->test('jobs-table', ['type' => 'jobs'])
            ->assertSee($softwareEngineerJob->title);
    });

    it('favourites a job from the list', function () {
        $user = User::find(UserEnum::MAIN->value);

        $job = Job::find(JobEnum::SOFTWARE_ENGINEER->value);
        $job->update(['favourited' => false]);

        Livewire::actingAs($user)
            ->test('jobs-table', ['type' => 'jobs'])
            ->assertSee('Add '.$job->title.' to favourites')
            ->call('toggleFavourite', $job->id)
            ->assertSee('Remove '.$job->title.' from favourites');

        expect($job->fresh()->favourited)->toBeTruthy();
    });

    it('shows a message when there are no favourites', function () {
        $user = User::find(UserEnum::MAIN->value);

        Job::where('user_id', $user->id)->update(['favourited' => false]);

        Livewire::actingAs($user)
            ->test('jobs-table', ['type' => 'favourite'])
            ->assertSee('No favourites yet');
    });
});
