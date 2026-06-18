<?php

namespace App\Actions\Job;

use App\Models\Job;

class GetByJobIdAction
{
    public function execute(int $userId, string|int $jobId): ?Job
    {
        return Job::where('user_id', $userId)
            ->where('job_id', $jobId)
            ->first();
    }
}
