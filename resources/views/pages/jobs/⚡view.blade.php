<?php

use App\Actions\Job\{FavouriteJobAction, GetByJobIdAction, GetJobAction};
use App\Models\Job;
use App\View\Components\BaseComponent;
use Carbon\Carbon;
use Illuminate\Support\Number;

new class extends BaseComponent
{
    #[Locked]
    public Job $job;

    public function toggleFavourite(): void
    {
        resolve(FavouriteJobAction::class)->execute($this->job->id);
        $this->job->favourited = !$this->job->favourited;
    }

    public function mount(string $id): void
    {
        $this->job = resolve(GetJobAction::class)->execute($id);
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
                /* Carbon::createFromFormat('Y-m-d', $job->posted_at)->format('d/m/Y') */
            </div>
            <div class="flex mb-4">
                <span class="w-24 font-extrabold">Salary:</span>
                <span>{{ $job->salary }}</span>
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
    <div class="description">{{ $job->description }}</div>
</div>