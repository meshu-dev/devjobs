<?php

use App\Actions\Job\FavouriteJobAction;
use App\Actions\Job\GetJobsAction;
use App\View\Components\BaseComponent;
use App\View\JobDates;
use App\View\SalaryBand;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Livewire\WithPagination;

new class extends BaseComponent
{
    use WithPagination;

    #[Locked]
    public string $type;

    #[Computed]
    public function jobs(): LengthAwarePaginator
    {
        return resolve(GetJobsAction::class)->execute(
            Auth::id(),
            $this->type === 'favourite'
        );
    }

    /**
     * The current page of jobs grouped by the day they were posted.
     */
    #[Computed]
    public function days(): Collection
    {
        return $this->jobs()->getCollection()->groupBy(
            fn ($job) => JobDates::day($job->posted_at)
        );
    }

    #[Computed]
    public function target(): array
    {
        $profile = Auth::user()->profile;

        return [$profile?->min_salary, $profile?->max_salary];
    }

    public function band($job): ?SalaryBand
    {
        [$min, $max] = $this->target();

        return SalaryBand::make((int) $job->min_salary, (int) $job->max_salary, $min ?: null, $max ?: null);
    }

    public function toggleFavourite(string $jobId): void
    {
        resolve(FavouriteJobAction::class)->execute($jobId);

        unset($this->jobs, $this->days);
    }

    public function mount($type): void
    {
        $this->type = $type;
    }
};
?>

<div>
    @if ($this->jobs()->total() > 0)
        <div class="-mt-3 mb-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-muted lg:-mt-5">
            <span>
                {{ trans_choice('{1} 1 job|[2,*] :count jobs', $this->jobs()->total()) }}.
                @if ($type !== 'favourite')
                    The next import runs {{ JobDates::nextImport() }}.
                @endif
            </span>
            @if ($this->target()[0] && $this->target()[1])
                <span class="flex items-center gap-2">
                    <span class="inline-block h-2.5 w-5 rounded-full bg-highlight" aria-hidden="true"></span>
                    Your target salary, £{{ Number::abbreviate($this->target()[0]) }}–£{{ Number::abbreviate($this->target()[1]) }}.
                    <a href="/profile" wire:navigate class="text-primary underline underline-offset-2">Change</a>
                </span>
            @endif
        </div>

        <div class="space-y-8">
            @foreach ($this->days() as $day => $jobs)
                <section wire:key="day-{{ $day }}" aria-labelledby="day-{{ Str::slug($day) }}">
                    <h2 id="day-{{ Str::slug($day) }}" class="mb-2 text-sm font-semibold">{{ $day }}</h2>

                    <ul class="divide-y divide-base-300 rounded-box border border-base-300 bg-base-100">
                        @foreach ($jobs as $job)
                            <li wire:key="job-{{ $job->id }}" class="group relative grid grid-cols-[2rem_1fr] gap-x-2 px-3 py-3.5 sm:grid-cols-[2rem_1fr_auto] sm:items-center sm:px-4">
                                <button type="button"
                                        wire:click="toggleFavourite('{{ $job->id }}')"
                                        aria-pressed="{{ $job->favourited ? 'true' : 'false' }}"
                                        aria-label="{{ $job->favourited ? 'Remove '.$job->title.' from favourites' : 'Add '.$job->title.' to favourites' }}"
                                        class="relative z-10 -m-1.5 self-start rounded-field p-1.5 text-muted hover:text-base-content focus-visible:outline-2 focus-visible:outline-primary sm:self-center cursor-pointer">
                                    @if ($job->favourited)
                                        <x-icon name="s-star" class="size-5 text-highlight [&_path]:stroke-base-content [&_path]:stroke-1" />
                                    @else
                                        <x-icon name="o-star" class="size-5" />
                                    @endif
                                </button>

                                <div class="min-w-0">
                                    <a href="/view/{{ $job->id }}" wire:navigate
                                       class="font-semibold leading-snug after:absolute after:inset-0 group-hover:underline underline-offset-2 rounded-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                                        {{ $job->title }}
                                    </a>
                                    <p class="mt-0.5 text-sm text-muted truncate">
                                        {{ collect([$job->employer, $job->location])->filter()->implode(', ') }}
                                    </p>
                                </div>

                                <div class="col-start-2 mt-2 flex items-center gap-3 text-sm sm:col-start-3 sm:mt-0 sm:justify-end">
                                    <span class="tabular font-medium whitespace-nowrap sm:w-28 sm:text-right {{ $job->salaryShortened === 'N/A' ? 'text-muted font-normal' : '' }}">
                                        {{ $job->salaryShortened === 'N/A' ? 'Salary not listed' : str_replace(' - ', '–', $job->salaryShortened) }}
                                    </span>
                                    <x-salary-band :band="$this->band($job)" />
                                    <span class="ms-auto w-16 text-right text-muted sm:ms-0">{{ $job->jobSite->name }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endforeach
        </div>

        @if ($this->jobs()->hasPages())
            <div class="mt-6">
                {{ $this->jobs()->links() }}
            </div>
        @endif
    @else
        <div class="rounded-box border border-dashed border-base-300 px-6 py-10 text-center">
            @if ($type === 'favourite')
                <p class="font-semibold">No favourites yet</p>
                <p class="mt-1 text-muted">Star a job in <a href="/" wire:navigate class="text-primary underline underline-offset-2">Jobs</a> to keep it here.</p>
            @else
                <p class="font-semibold">No jobs yet</p>
                <p class="mt-1 text-muted">The next import runs {{ JobDates::nextImport() }}.</p>
            @endif
        </div>
    @endif
</div>
