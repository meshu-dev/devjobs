<?php

namespace App\Actions\Job;

use App\Models\Job;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class GetJobsAction
{
    public function execute(int $userId, bool $favourited = false): LengthAwarePaginator
    {
        $model = Job::where('user_id', $userId)
                    ->orderBy('posted_at', 'desc');

        $model = $favourited ? $model->where('favourited', true) : $model;

        $pageLimit = config('jobs.pagination.page_limit');

        return $model->paginate($pageLimit);
    }
}
