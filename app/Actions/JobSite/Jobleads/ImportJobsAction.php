<?php

namespace App\Actions\JobSite\Jobleads;

use App\Actions\Job\GetByJobIdAction;
use App\Actions\JobSite\Jobleads\Api\SearchJobsAction;
use App\Actions\JobSite\Jobleads\Api\GetJobAction;
use App\Enums\JobSiteEnum;
use App\Models\{Job, User};
use Carbon\Carbon;
use Illuminate\Support\Sleep;

class ImportJobsAction
{
    public function execute(User $user): int
    {
        $searchTerms = $user->profile->search_terms ?? [];
        
        $jobs = resolve(SearchJobsAction::class)->execute($searchTerms);
        $jobs = $jobs['jobResults'];
        
        $count = 0;

        foreach ($jobs as $job) {
            $result = $this->createJob($user->id, $job);

            if ($result) {
                $count++;
            }

            echo 'Site: Jobleads | Job title: ' . $job['jobTitle'] . ' | User: ' . $user->name . PHP_EOL;

            Sleep::for(500)->milliseconds();
        }
        return $count;
    }

    /**
     * @param array<string, mixed> $job
     */
    private function createJob(int $userId, array $job): Job|false
    {
        $jobModel = resolve(GetByJobIdAction::class)->execute($userId, $job['id']);

        if ($jobModel || $job['alpha2Country'] !== 'GB') {
            return false;
        }

        $params = [
            'user_id'     => $userId,
            'job_site_id' => JobSiteEnum::JOBLEADS->value,
            'job_id'      => $job['id'],
            'title'       => $job['jobTitle'],
            'description' => $this->getDescription($job['id']),
            'employer'    => $job['companyName'] ?? '',
            'location'    => $this->getLocation($job),
            'min_salary'  => $job['minSalary'] > 0 ? (int) $job['minSalary'] : 0,
            'max_salary'  => $job['maxSalary'] > 0 ? (int) $job['maxSalary'] : 0,
            'url'         => JobSiteEnum::JOBLEADS->url() . $job['jobLink'],
            'params'      => ['countryCode' => $job['alpha2Country'], 'salaryCurrency' => $job['salaryCurrency']],
            'posted_at'   => Carbon::parse($job['validFrom']),
        ];

        return Job::create($params);
    }

    /**
     * @param array<string, mixed> $job
     */
    private function getLocation(array $job): string
    {
        if (!empty($job['cityName'][0])) {
            return $job['cityName'][0];
        }

        if (!empty($job['regionName'][0])) {
            return $job['regionName'][0];
        }

        return 'United Kingdom';
    }

    private function getDescription(string $jobId): string|null
    {
        $jobData = resolve(GetJobAction::class)->execute($jobId);

        if (isset($jobData['payload'])) {
            return view('templates.jobleads', $jobData['payload']['content'])->render();
        }
        return null;
    }
}
