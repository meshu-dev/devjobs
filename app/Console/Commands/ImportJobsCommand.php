<?php

namespace App\Console\Commands;

use App\Actions\Job\ImportAllUserJobsAction;
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
        resolve(ImportAllUserJobsAction::class)->execute();
    }
}
