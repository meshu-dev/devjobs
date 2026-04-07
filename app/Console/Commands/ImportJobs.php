<?php

namespace App\Console\Commands;

use App\Actions\Reed\ImportJobsAction as ReedImportJobsAction;
use App\Actions\Larajobs\ImportJobsAction as LarajobsImportJobsAction;
use Illuminate\Console\Command;

class ImportJobs extends Command
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
    public function handle()
    {
        resolve(ReedImportJobsAction::class)->execute();
        resolve(LarajobsImportJobsAction::class)->execute();
    }
}
