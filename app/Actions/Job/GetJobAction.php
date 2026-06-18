<?php

namespace App\Actions\Job;

use App\Enums\JobSiteEnum;
use App\Models\Job;

class GetJobAction
{
    public function execute(string $id): ?Job
    {
        $job = Job::find($id);

        if ($job?->description && $job->jobSite?->id === JobSiteEnum::LARAJOBS->value) {
            $job->description = config('jobs.descriptions.'.JobSiteEnum::LARAJOBS->value);
        }

        return $job;
    }
}
