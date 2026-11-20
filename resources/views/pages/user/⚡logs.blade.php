<?php

use App\Actions\SystemLog\GetSystemLogsAction;
use App\View\Components\BaseComponent;
use App\View\JobDates;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

new class extends BaseComponent
{
    use WithPagination;

    #[Computed]
    public function logs(): LengthAwarePaginator
    {
        return resolve(GetSystemLogsAction::class)->execute(Auth::id());
    }
};
?>

<div>
    <livewire:header title="Import history" :subtitle="'Jobs are imported every day at '.config('jobs.import_time').'.'" />

    @if ($this->logs()->total() > 0)
        <ul class="divide-y divide-base-300 rounded-box border border-base-300 bg-base-100">
            @foreach ($this->logs() as $log)
                @php($newJobs = (int) ($log->context['totalNewJobs'] ?? 0))
                <li wire:key="log-{{ $log->id }}" class="flex items-center gap-4 px-4 py-3.5">
                    <div class="min-w-0 flex-1">
                        <p class="font-medium">
                            @if ($log->created_at)
                                {{ JobDates::day($log->created_at) }}<span class="text-muted font-normal">, {{ $log->created_at->format('H:i') }}</span>
                            @else
                                Date not recorded
                            @endif
                        </p>
                        <p class="mt-0.5 text-sm text-muted truncate">{{ $log->text }}</p>
                    </div>
                    <span @class(['tabular text-sm whitespace-nowrap', 'font-semibold' => $newJobs > 0, 'text-muted' => $newJobs === 0])>
                        {{ $newJobs === 0 ? 'No new jobs' : trans_choice('{1} 1 new job|[2,*] :count new jobs', $newJobs) }}
                    </span>
                </li>
            @endforeach
        </ul>

        @if ($this->logs()->hasPages())
            <div class="mt-6">{{ $this->logs()->links() }}</div>
        @endif
    @else
        <div class="rounded-box border border-dashed border-base-300 px-6 py-10 text-center">
            <p class="font-semibold">No imports yet</p>
            <p class="mt-1 text-muted">The first import runs {{ JobDates::nextImport() }}.</p>
        </div>
    @endif
</div>
