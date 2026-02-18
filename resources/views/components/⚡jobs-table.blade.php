<?php

use App\Actions\Job\GetJobsAction;
use App\View\Components\BaseComponent;
use Illuminate\Pagination\LengthAwarePaginator;

new class extends BaseComponent
{
    #[Locked]
    public array $headers;

    #[Locked]
    public string $type;

    #[Computed]
    public function jobs(): LengthAwarePaginator
    {
        return resolve(GetJobsAction::class)->execute($this->type === 'favourite' ? true : false);
    }

    public function mount($type): void
    {
        $this->headers = [
            ['key' => 'title',     'label' => 'Title'],
            ['key' => 'location',  'label' => 'Location'],
            ['key' => 'posted_at', 'label' => 'Posted At'],
        ];

        $this->type = $type;
    }
};
?>

<div>
    <x-table
        :headers="$headers"
        :rows="$this->jobs()"
        with-pagination>
        @scope('cell_title', $job)
            <a href="/view/{{ $job->id }}" wire:navigate class="data-current:font-bold">{{ $job->title }}</a>
        @endscope 
    </x-table>
</div>