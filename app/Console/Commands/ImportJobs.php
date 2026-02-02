<?php

namespace App\Console\Commands;

use App\Actions\Reed\ImportJobsAction;
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
        resolve(ImportJobsAction::class)->execute();
    }
}
