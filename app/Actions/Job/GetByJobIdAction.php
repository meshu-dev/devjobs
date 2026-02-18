<?php

namespace App\Actions\Job;

use App\Models\Job;

class GetByJobIdAction
{
    public function execute(int $jobId): Job|null
    {
        return Job::where('job_id', $jobId)->first();
    }
}
