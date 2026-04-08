<?php

namespace App\Actions\Job;

use App\Actions\JobSite\Reed\ImportJobsAction as ReedImportJobsAction;
use App\Actions\JobSite\Larajobs\ImportJobsAction as LarajobsImportJobsAction;
use App\Actions\JobSite\Jobleads\ImportJobsAction as JobleadsImportJobsAction;
use App\Models\User;

class ImportJobsAction
{
    public function execute(User $user): void
    {
        resolve(ReedImportJobsAction::class)->execute($user);
        resolve(LarajobsImportJobsAction::class)->execute($user);
        resolve(JobleadsImportJobsAction::class)->execute($user);
    }
}
