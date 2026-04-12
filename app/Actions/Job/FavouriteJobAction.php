<?php

namespace App\Actions\Job;

use App\Models\Job;

class FavouriteJobAction
{
    public function execute(string $jobId): void
    {
        $job = Job::find($jobId);
        $job->favourited = $job->favourited ? false : true;
        $job->save();
    }
}
