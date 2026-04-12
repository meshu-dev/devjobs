<?php

namespace App\Actions\Job;

use App\Models\Job;
use App\Models\User;

class ResetJobsAction
{
    public function execute(User $user): void
    {
        if ($user->profile?->reset_jobs) {
            Job::where('user_id', $user->id)->delete();

            $user->profile->reset_jobs = false;
            $user->profile->save();
        }
    }
}
