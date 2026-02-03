<?php

namespace App\Actions\Reed;

use App\Actions\Job\GetByJobIdAction;
use App\Actions\Reed\Api\GetJobAction;
use App\Actions\Reed\Api\SearchJobsAction;
use App\Models\Job;
use Carbon\Carbon;

class ImportJobsAction
{
    public function execute(): void
    {
        $jobsResult = resolve(SearchJobsAction::class)->execute('php developer');
        $jobs       = $jobsResult['results'];

        $getJobAction = resolve(GetByJobIdAction::class);

        foreach ($jobs as $jobData) {
            $jobId = $jobData['jobId'];
            $job   = $getJobAction->execute($jobId);

            if (!$job) {
                $this->createJob($jobId);
            }
        }
    }

    private function createJob(int $jobId)
    {
        $job = resolve(GetJobAction::class)->execute($jobId);

        $params = [
            'job_id'      => $job['jobId'],
            'title'       => $job['jobTitle'],
            'description' => $job['jobDescription'],
            'employer'    => $job['employerName'],
            'location'    => $job['locationName'],
            'min_salary'  => (int) $job['minimumSalary'],
            'max_salary'  => (int) $job['maximumSalary'],
            'url'         => $job['jobUrl'],
            'params'      => ['applicationCount' => $job['applicationCount']],
            'posted_at'   => Carbon::createFromFormat('d/m/Y', $job['datePosted']),
        ];

        Job::create($params);
    }
}
