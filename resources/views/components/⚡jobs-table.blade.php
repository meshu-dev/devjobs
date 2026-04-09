<?php

use App\Actions\Job\GetJobsAction;
use App\View\Components\BaseComponent;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

new class extends BaseComponent
{
    #[Locked]
    public array $headers;

    #[Locked]
    public string $type;

    #[Computed]
    public function jobs(): LengthAwarePaginator
    {
        $user = Auth::user();

        return resolve(GetJobsAction::class)->execute(
            $user->id,
            $this->type === 'favourite' ? true : false
        );
    }

    public function mount($type): void
    {
        $this->headers = [
            ['key' => 'title',     'label' => 'Title'],
            ['key' => 'jobsite',   'label' => 'Job Site'],
            ['key' => 'location',  'label' => 'Location'],
            ['key' => 'posted_at', 'label' => 'Posted At'],
        ];

        $this->type = $type;
    }
};
?>

<div>
    @if ($this->jobs()->total() > 0)
        <x-table
            :headers="$headers"
            :rows="$this->jobs()"
            with-pagination>
            @scope('cell_title', $job)
                <a href="/view/{{ $job->id }}" wire:navigate class="data-current:font-bold">{{ $job->title }}</a>
            @endscope
            @scope('cell_jobsite', $job)
                {{ $job->jobSite->name }}
            @endscope 
            @scope('cell_posted_at', $job)
                {{ Carbon::createFromFormat('Y-m-d', $job->posted_at)->format('d/m/Y') }}
            @endscope 
        </x-table>
    @else
        <div>No jobs added</div>
    @endif
</div>