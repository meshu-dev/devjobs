<?php

namespace App\Actions\Reed;

use App\Models\Job;

class CreateAction
{
    public function execute(array $params): Job|null
    {
        return Job::create($params);
    }
}
