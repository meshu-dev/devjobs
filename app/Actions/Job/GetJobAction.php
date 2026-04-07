<?php

namespace App\Actions\Job;

use App\Models\Job;

class GetJobAction
{
    public function execute(int $id): Job|null
    {
        $job = Job::find($id);
        
        if (!$job->description) {
            $job->description = config('jobs.descriptions.' . $job->jobSite->id);
        }

        return $job;
    }
}
