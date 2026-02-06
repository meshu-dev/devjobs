<?php

namespace App\Actions\Reed;

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

    private function createJob(Item $job): void
    {
        $data   = $job->data['child']['https://larajobs.com'];
        $salary = $data['salary'][0]['data'];

        if (str_contains($salary, '-')) {
            [$minSalary, $maxSalary] = explode('-', $salary);
            $minSalary = filter_var(str_replace(',', '', $minSalary), FILTER_SANITIZE_NUMBER_INT);
            $maxSalary = filter_var(str_replace(',', '', $maxSalary), FILTER_SANITIZE_NUMBER_INT);
        } else {
            $minSalary = $maxSalary = $salary;
        }

        $params = [
            'job_id'      => Uri::of($job->get_id())->pathSegments()[1],
            'title'       => $job->get_title(),
            'description' => null,
            'employer'    => $data['company'][0]['data'] ?? '',
            'location'    => $data['location'][0]['data'] ?? '',
            'min_salary'  => $minSalary,
            'max_salary'  => $maxSalary,
            'url'         => $job->get_link(),
            'params'      => [],
            'posted_at'   => Carbon::parse($job->get_date()),
        ];

        Job::create($params);
    }
}
