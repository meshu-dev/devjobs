<?php

use App\Actions\Job\GetJobsAction;
use App\View\Components\BaseComponent;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

new class extends BaseComponent
{
    use WithPagination; 

    #[Locked]
    public array $headers;

    #[Computed]
    public function jobs(): LengthAwarePaginator
    {
        return resolve(GetJobsAction::class)->execute();
    }

    public function mount(): void
    {
        $this->headers = [
            ['key' => 'title',     'label' => 'Title'],
            ['key' => 'location',  'label' => 'Location'],
            ['key' => 'posted_at', 'label' => 'Posted At'],
        ];
    }
};
?>

<div>
    <livewire:header title="Jobs" />
    <x-table
        :headers="$headers"
        :rows="$this->jobs()"
        with-pagination>
        @scope('cell_title', $job)
            <a href="/view/{{ $job->id }}" wire:navigate class="data-current:font-bold">{{ $job->title }}</a>
        @endscope 
    </x-table>
</div>