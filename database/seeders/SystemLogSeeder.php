<?php

namespace Database\Seeders;

use App\Enums\UserEnum;
use App\Models\SystemLog;
use Illuminate\Database\Seeder;

class SystemLogSeeder extends Seeder
{
    public function run(): void
    {
        SystemLog::insert([
            [
                'user_id' => UserEnum::MAIN->value,
                'text' => 'Job importer ran successfully',
                'context' => json_encode(['totalNewJobs' => 3]),
            ],
        ]);
    }
}
