<?php

namespace App\Actions\JobSite\Reed;

use App\Actions\Job\GetByJobIdAction;
use App\Actions\JobSite\Reed\Api\GetJobAction as GetReedJobAction;
use App\Actions\JobSite\Reed\Api\SearchJobsAction;
use App\Enums\JobSiteEnum;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;

class ImportJobsAction
{
    public function execute(User $user): void
    {
        $minSalary = $user->profile->min_salary;

        foreach ($user->profile->search_terms as $searchTerm) {
            $jobs = $this->getReedJobs($searchTerm, $minSalary);

            foreach ($jobs as $jobData) {
                $this->createJob($user->id, $jobData['jobId']);
            }
        }
    }

    private function getReedJobs(string $searchTerm, int $minSalary)
    {
        $jobsResult = resolve(SearchJobsAction::class)->execute($searchTerm, $minSalary);
        $jobs       = $jobsResult['results'];

        return $jobs;
    }

    private function createJob(int $userId, int $jobId): void
    {
        $job = resolve(GetByJobIdAction::class)->execute($userId, $jobId);

        if ($job) {
            return;
        }

        $reedJob = resolve(GetReedJobAction::class)->execute($jobId);

        $params = [
            'user_id'     => $userId,
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
