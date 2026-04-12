<?php

namespace App\Actions\JobSite\Larajobs;

use App\Actions\Job\GetByJobIdAction;
use App\Actions\JobSite\Larajobs\Feed\GetJobsAction;
use App\Enums\JobSiteEnum;
use App\Models\{Job, User};
use Carbon\Carbon;
use Stringable;
use SimplePie\Item;
use Illuminate\Support\Uri;

class ImportJobsAction
{
    public function execute(User $user): void
    {
        $jobs = resolve(GetJobsAction::class)->execute();

        foreach ($jobs as $job) {
            $this->createJob($user->id, $job);
        }
    }

    private function createJob(int $userId, Item $jobItem): void
    {
        /** @var string|Stringable $jobUrl */
        $jobUrl = $jobItem->get_id();

        $jobId  = Uri::of($jobUrl)->pathSegments()[1];
        $job    = resolve(GetByJobIdAction::class)->execute($userId, $jobId);

        if ($job) {
            return;
        }

        $data   = $jobItem->data['child']['https://larajobs.com'];
        $salary = $data['salary'][0]['data'];

        if (str_contains($salary, '-')) {
            [$minSalary, $maxSalary] = explode('-', $salary);
            $minSalary = filter_var(str_replace(',', '', $minSalary), FILTER_SANITIZE_NUMBER_INT);
            $maxSalary = filter_var(str_replace(',', '', $maxSalary), FILTER_SANITIZE_NUMBER_INT);
        } else {
            $minSalary = $maxSalary = $salary;
        }

        $params = [
            'user_id'     => $userId,
            'job_site_id' => JobSiteEnum::LARAJOBS->value,
            'job_id'      => $jobId,
            'title'       => $jobItem->get_title(),
            'description' => null,
            'employer'    => $data['company'][0]['data'] ?? '',
            'location'    => $data['location'][0]['data'] ?? '',
            'min_salary'  => $minSalary > 0 ? (int) $minSalary : 0,
            'max_salary'  => $maxSalary > 0 ? (int) $maxSalary : 0,
            'url'         => $jobItem->get_link(),
            'params'      => [],
            'posted_at'   => Carbon::parse($jobItem->get_date()),
        ];

        Job::create($params);
    }
}
