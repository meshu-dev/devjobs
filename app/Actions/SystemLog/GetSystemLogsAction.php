<?php

namespace App\Actions\SystemLog;

use App\Models\SystemLog;
use Illuminate\Pagination\LengthAwarePaginator;

class GetSystemLogsAction
{
    /**
     * @return LengthAwarePaginator<int, SystemLog>
     **/
    public function execute(int $userId): LengthAwarePaginator
    {
        $pageLimit = config('jobs.pagination.page_limit');

        return SystemLog::where('user_id', $userId)->paginate($pageLimit);
    }
}
