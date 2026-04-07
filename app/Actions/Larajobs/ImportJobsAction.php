<?php

namespace App\Actions\Larajobs;

use App\Actions\Job\GetByJobIdAction;
use App\Models\Job;
use Carbon\Carbon;
use SimplePie\Item;
use Illuminate\Support\Uri;
use willvincent\Feeds\Facades\FeedsFacade;

class ImportJobsAction
{
    public function execute(): void
    {
        $url  = config('services.larajobs.url');
        $feed = FeedsFacade::make($url);
        $jobs = $feed->get_items();

        foreach ($jobs as $job) {
            $this->createJob($job);
        }
    }

    private function createJob(Item $jobItem): void
    {
        $jobId = Uri::of($jobItem->get_id())->pathSegments()[1];
        $job   = resolve(GetByJobIdAction::class)->execute($jobId);

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
