<?php

namespace App\Actions\Job;

use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;

class GetJobsAction
{
    public function execute(bool $favourited = false): LengthAwarePaginator
    {
        $model = Job::orderBy('posted_at', 'desc');
        $model = $favourited ? $model->where('favourited', true) : $model;

        return $model->paginate();
    }
}
