<?php

use App\Actions\Job\FavouriteJobAction;
use App\Actions\Job\GetJobAction;
use App\Models\Job;
use App\View\Components\BaseComponent;
use App\View\JobDates;
use App\View\SalaryBand;
use Illuminate\Support\Facades\Auth;

new class extends BaseComponent
{
    #[Locked]
    public Job $job;

    public function toggleFavourite(): void
    {
        resolve(FavouriteJobAction::class)->execute(Auth::id(), $this->job->id);
        $this->job->favourited = ! $this->job->favourited;
    }

    public function band(): ?SalaryBand
    {
        $profile = Auth::user()->profile;

        return SalaryBand::make(
            (int) $this->job->min_salary,
            (int) $this->job->max_salary,
            $profile?->min_salary ?: null,
            $profile?->max_salary ?: null,
        );
    }

    public function mount(string $id): void
    {
        $this->job = resolve(GetJobAction::class)->execute(Auth::id(), $id) ?? abort(404);
    }
};
?>

<div>
    <a href="/" wire:navigate class="mb-4 inline-flex items-center gap-1 text-sm text-muted hover:text-base-content">
        <x-icon name="o-chevron-left" class="size-4" />
        Jobs
    </a>

    <header class="mb-6">
        <h1 class="text-[1.75rem] leading-tight font-bold tracking-tight text-balance lg:text-3xl">{{ $job->title }}</h1>
        <p class="mt-1 text-lg text-muted">{{ collect([$job->employer, $job->location])->filter()->implode(', ') }}</p>
    </header>

    <div class="flex flex-col-reverse gap-8 lg:grid lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-start lg:gap-12">
        <article class="description">{{ $job->description }}</article>

        <aside class="rounded-box border border-base-300 bg-base-100 p-5 lg:sticky lg:top-6">
            <dl class="grid grid-cols-2 gap-4 text-sm lg:grid-cols-1">
                <div class="col-span-2 lg:col-span-1">
                    <dt class="text-muted">Salary</dt>
                    <dd class="mt-0.5 text-base font-semibold">
                        {{ $job->salary === 'N/A' ? 'Not listed' : str_replace(' - ', ' to ', str_replace('.00', '', $job->salary)) }}
                    </dd>
                    @if ($band = $this->band())
                        <dd class="mt-2 flex flex-col gap-1.5">
                            <x-salary-band :band="$band" class="w-full" />
                            <span class="text-muted">{{ Str::after($band->label, '. ') }}</span>
                        </dd>
                    @endif
                </div>
                <div>
                    <dt class="text-muted">Posted</dt>
                    <dd class="mt-0.5">{{ JobDates::day($job->posted_at) }}</dd>
                </div>
                <div>
                    <dt class="text-muted">Found on</dt>
                    <dd class="mt-0.5">{{ $job->jobSite->name }}</dd>
                </div>
            </dl>

            <div class="mt-5 flex flex-col gap-2">
                <x-button
                    :label="'View on '.$job->jobSite->name"
                    icon-right="o-arrow-top-right-on-square"
                    class="btn-primary"
                    :link="$job->url"
                    external />
                <x-button
                    :label="$job->favourited ? 'Remove from favourites' : 'Add to favourites'"
                    :icon="$job->favourited ? 's-star' : 'o-star'"
                    aria-pressed="{{ $job->favourited ? 'true' : 'false' }}"
                    class="btn-outline border-base-300 bg-base-100 font-medium whitespace-nowrap {{ $job->favourited ? '[&_svg]:text-highlight [&_svg_path]:stroke-base-content [&_svg_path]:stroke-1' : '' }}"
                    wire:click="toggleFavourite()"
                    spinner="toggleFavourite" />
            </div>
        </aside>
    </div>
</div>
