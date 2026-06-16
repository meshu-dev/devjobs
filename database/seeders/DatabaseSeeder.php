<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(JobSiteSeeder::class);

        if (!App::environment('production')) {
            $this->call(JobSeeder::class);
            $this->call(SystemLogSeeder::class);
        }
    }
}
