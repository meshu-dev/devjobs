<?php

use App\Actions\Job\{FavouriteJobAction, GetByJobIdAction};
use App\Models\Job;
use App\View\Components\BaseComponent;

new class extends BaseComponent
{
    #[Locked]
    public Job $job;

    public function toggleFavourite(): void
    {
        resolve(FavouriteJobAction::class)->execute($this->job->id);
        $this->job->favourited = !$this->job->favourited;
    }

    public function mount(int $id): void
    {
        $this->job = Job::find($id);
    }
};
?>

<div>
    <livewire:header :title="$job->title" />
    <div class="flex mb-2">
        <div class="flex-1">
            <div class="flex mb-4">
                <span class="w-24 font-extrabold">Recruiter:</span>
                <span>{{ $job->employer }}</span>
            </div>
            <div class="flex">
                <span class="w-24 font-extrabold">Location:</span>
                <span>{{ $job->location }}</span>
            </div>
        </div>
        <div class="flex-1">
            <div class="flex mb-4">
                <span class="w-24 font-extrabold">Posted At:</span>
                <span>{{ $job->posted_at }}</span>
            </div>
            <div class="flex mb-4">
                <span class="w-24 font-extrabold">Salary:</span>
                <span>{{ $job->min_salary }} - {{ $job->max_salary }}</span>
            </div>
        </div>
    </div>
    <div class="flex mb-6 gap-2">
        <x-button
            :label="$job->favourited ? 'Unfavourite' : 'Favourite'"
            wire:click="toggleFavourite()" />
        <x-button
            label="View Original"
            :link="$job->url"
            external />
    </div>
    <div wire:replace>{!! $job->description !!}</div>
</div>