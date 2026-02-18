<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Software Engineer',
            ],
            [
                'title' => 'PHP Developer',
            ],
            [
                'title' => 'Laravel Developer',
            ]
        ];

        foreach ($jobs as $job) {
            Job::factory()->create($job);
        }
    }
}
