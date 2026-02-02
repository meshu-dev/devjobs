<?php

namespace App\Actions\Job;

use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;

class GetJobsAction
{
    public function execute(bool $ordered = true): LengthAwarePaginator
    {
        if ($ordered) {
            return Job::orderBy('posted_at', 'desc')->paginate();
        }
        return Job::paginate();
    }
}
