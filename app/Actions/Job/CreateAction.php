<?php

namespace App\Actions\Reed;

use App\Models\Job;

class CreateAction
{
    /**
     * @param array<string, mixed> $params
     */
    public function execute(array $params): Job|null
    {
        return Job::create($params);
    }
}
