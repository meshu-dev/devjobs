<?php

namespace App\Actions\Job;

use App\Models\Job;

class FavouriteJobAction
{
    public function execute(int $jobId): void
    {
        $job = Job::find($jobId);
        $job->favourited = $job->favourited ? false : true;
        $job->save();
    }
}
