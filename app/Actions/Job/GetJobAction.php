<?php

namespace App\Actions\Job;

use App\Models\Job;

class GetJobAction
{
    public function execute(string $id): Job|null
    {
        $job = Job::find($id);
        
        if ($job && $job->jobSite) {
            $job->description = config('jobs.descriptions.' . $job->jobSite->id);
        }

        return $job;
    }
}
