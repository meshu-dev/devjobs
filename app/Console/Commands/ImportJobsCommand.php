<?php

namespace App\Console\Commands;

use App\Actions\Job\ImportJobsAction;
use App\Models\User;
use Illuminate\Console\Command;

class ImportJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the lastest jobs';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        User::all()->each(
            fn (User $user) => resolve(ImportJobsAction::class)->execute($user)    
        );
    }
}
