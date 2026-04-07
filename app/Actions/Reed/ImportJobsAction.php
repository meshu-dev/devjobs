<?php

namespace App\Actions\Reed;

use App\Actions\Job\GetByJobIdAction;
use App\Actions\Reed\Api\GetJobAction as GetReedJobAction;
use App\Actions\Reed\Api\SearchJobsAction;
use App\Enums\JobSiteEnum;
use App\Models\Job;
use Carbon\Carbon;

class ImportJobsAction
{
    public function execute(): void
    {
        $searchTerms = [
            'php developer',
            'laravel developer',
        ];

        foreach ($searchTerms as $searchTerm) {
            $jobs = $this->getReedJobs($searchTerm);

            foreach ($jobs as $jobData) {
                $this->createJob($jobData['jobId']);
            }
        }
    }

    private function getReedJobs(string $searchTerm, int $offset = 0)
    {
        $jobsResult = resolve(SearchJobsAction::class)->execute($searchTerm, $offset);
        $jobs       = $jobsResult['results'];

        return $jobs;
    }

    private function createJob(int $jobId): void
    {
        $job = resolve(GetByJobIdAction::class)->execute($jobId);

        if ($job) {
            return;
        }

        $reedJob = resolve(GetReedJobAction::class)->execute($jobId);

        $params = [
            'job_site_id' => JobSiteEnum::REED->value,
            'job_id'      => $reedJob['jobId'],
            'title'       => $reedJob['jobTitle'],
            'description' => $reedJob['jobDescription'],
            'employer'    => $reedJob['employerName'],
            'location'    => $reedJob['locationName'],
            'min_salary'  => (int) $reedJob['minimumSalary'],
            'max_salary'  => (int) $reedJob['maximumSalary'],
            'url'         => $reedJob['jobUrl'],
            'params'      => ['applicationCount' => $reedJob['applicationCount']],
            'posted_at'   => Carbon::createFromFormat('d/m/Y', $reedJob['datePosted']),
        ];

        Job::create($params);
    }
}
