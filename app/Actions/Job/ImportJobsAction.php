<?php

namespace App\Actions\Job;

use App\Actions\JobSite\Reed\ImportJobsAction as ReedImportJobsAction;
use App\Actions\JobSite\Larajobs\ImportJobsAction as LarajobsImportJobsAction;
use App\Actions\JobSite\Jobleads\ImportJobsAction as JobleadsImportJobsAction;
use App\Actions\SystemLog\CreateSystemLogAction;
use App\Enums\JobSiteEnum;
use App\Exceptions\ApiException;
use App\Models\User;

class ImportJobsAction
{
    private const LOG_MESSAGE = 'Job importer ran successfully';

    public function execute(User $user): void
    {
        resolve(ResetJobsAction::class)->execute($user);

        $importers = [
            JobSiteEnum::REED->name()     => ReedImportJobsAction::class,
            JobSiteEnum::LARAJOBS->name() => LarajobsImportJobsAction::class,
            JobSiteEnum::JOBLEADS->name() => JobleadsImportJobsAction::class,
        ];

        $logData = ['sites' => [], 'totalNewJobs' => 0];

        foreach ($importers as $site => $importer) {
            $result = $this->runImportAction($importer, $user);
        
            $logData['sites'][$site]['newJobs'] = $result;
            $logData['totalNewJobs'] += $result;
        }

        resolve(CreateSystemLogAction::class)->execute(
            $user->id,
            self::LOG_MESSAGE,
            $logData
        );
    }

    /**
     * @param string $action
     */
    private function runImportAction(string $action, User $user): int|false
    {
        try {
            return resolve($action)->execute($user);
        } catch (ApiException $exception) {
            echo 'Error with action ' . $action . ' | ' . $exception->getMessage() . PHP_EOL;
            return false;
        }
    }
}
