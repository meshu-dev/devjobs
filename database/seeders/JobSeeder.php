<?php

namespace Database\Seeders;

use App\Enums\{JobEnum, JobSiteEnum, UserEnum};
use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'id' => JobEnum::SOFTWARE_ENGINEER->value,
                'user_id' => UserEnum::MAIN->value,
                'job_site_id' => JobSiteEnum::REED->value,
                'job_id' => 1,
                'title' => 'Software Engineer',
            ],
            [
                'id' => JobEnum::PHP_DEVELOPER->value,
                'user_id' => UserEnum::MAIN->value,
                'job_site_id' => JobSiteEnum::REED->value,
                'job_id' => 2,
                'title' => 'PHP Developer',
            ],
            [
                'id' => JobEnum::LARAVEL_DEVELOPER->value,
                'user_id' => UserEnum::MAIN->value,
                'job_site_id' => JobSiteEnum::LARAJOBS->value,
                'job_id' => 3,
                'title' => 'Laravel Developer',
            ]
        ];

        foreach ($jobs as $job) {
            Job::factory()->create($job);
        }
    }
}
