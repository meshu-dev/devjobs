<?php

namespace App\Actions\Job;

use App\Models\Job;

class FavouriteJobAction
{
    public function execute(int $userId, string $jobId): void
    {
        $job = Job::where('user_id', $userId)->find($jobId);

        if ($job) {
            $job->favourited = ! $job->favourited;
            $job->save();
        }
    }
}
