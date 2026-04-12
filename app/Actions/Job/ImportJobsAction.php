<?php

namespace App\Actions\Job;

use App\Actions\JobSite\Reed\ImportJobsAction as ReedImportJobsAction;
use App\Actions\JobSite\Larajobs\ImportJobsAction as LarajobsImportJobsAction;
use App\Actions\JobSite\Jobleads\ImportJobsAction as JobleadsImportJobsAction;
use App\Exceptions\ApiException;
use App\Models\User;

class ImportJobsAction
{
    public function execute(User $user): void
    {
        resolve(ResetJobsAction::class)->execute($user);

        $this->runImportAction(
            [
                ReedImportJobsAction::class,
                LarajobsImportJobsAction::class,
                JobleadsImportJobsAction::class,
            ],
            $user
        );
    }

    private function runImportAction(array $actions, User $user): void
    {
        foreach ($actions as $action) {
            try {
                resolve($action)->execute($user);
            } catch (ApiException $exception) {
                echo 'Error with action ' . $action . ' | ' . $exception->getMessage() . PHP_EOL;
            }
        }
    }
}
