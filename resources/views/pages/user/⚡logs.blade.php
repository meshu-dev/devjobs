<?php

use App\Actions\SystemLog\GetSystemLogsAction;
use App\View\Components\BaseComponent;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends BaseComponent
{
    #[Locked]
    public array $headers;

    #[Computed]
    public function logs(): LengthAwarePaginator
    {
        $user = Auth::user();

        return resolve(GetSystemLogsAction::class)->execute($user->id);
    }

    public function mount()
    {
        $user = Auth::user();

        $this->headers = [
            ['key' => 'text',       'label' => 'Message'],
            ['key' => 'new_jobs',   'label' => 'New Jobs'],
            ['key' => 'created_at', 'label' => 'Date'],
        ];
    }
};
?>

<div>
    <livewire:header title="Logs" />
    @if ($this->logs()->total() > 0)
        <x-table
            :headers="$headers"
            :rows="$this->logs()"
            with-pagination>
            @scope('cell_new_jobs', $log)
                {{ $log['context']['totalNewJobs'] }}
            @endscope 
            @scope('cell_created_at', $log)
                {{ $log->created_at }}
                /* Carbon::parse($log->created_at)->format('d/m/Y') */
            @endscope 
        </x-table>
    @else
        <div>No logs added</div>
    @endif
</div>